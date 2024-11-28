#include <ESP8266WiFi.h>
#include <DHT.h>
#include <DHT_U.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>

// Konfigurasi WiFi
const char* ssid = "(nama wifi anda)";
const char* password = "(password wifi anda)"; 

// Konfigurasi DHT22
#define DHTPIN D7 // Pin untuk DHT22
#define DHTTYPE DHT22
DHT dht(DHTPIN, DHTTYPE);

// Konfigurasi URL server Laravel
const char* serverUrl = "http://localhost:8000/api/sensor-data"; // Ganti dengan IP server Laravel

void setup() {
  // Inisialisasi Serial Monitor
  Serial.begin(115200);
  delay(10);

  // Inisialisasi DHT
  dht.begin();

  // Hubungkan ke WiFi
  Serial.println("Menghubungkan ke WiFi...");
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.print(".");
  }
  Serial.println("\nWiFi Terhubung!");
  Serial.print("IP Address: ");
  Serial.println(WiFi.localIP());
}

void loop() {
  // Baca data suhu dan kelembaban
  float temperature = dht.readTemperature();
  float humidity = dht.readHumidity();

  // Periksa apakah pembacaan berhasil
  if (isnan(temperature) || isnan(humidity)) {
    Serial.println("Gagal membaca data dari sensor DHT!");
    return;
  }

  // Tampilkan data di Serial Monitor
  Serial.print("Suhu: ");
  Serial.print(temperature);
  Serial.print(" °C, Kelembapan: ");
  Serial.print(humidity);
  Serial.println(" %");

  // Kirim data ke server
  if (WiFi.status() == WL_CONNECTED) {
    WiFiClient client;
    HTTPClient http;

    // Siapkan JSON untuk dikirim
    String postData = "{\"temperature\":" + String(temperature) + ",\"humidity\":" + String(humidity) + "}";

    // Kirim data ke endpoint
    http.begin(client, serverUrl);  // Note the change here: added WiFiClient
    http.addHeader("Content-Type", "application/json");

    int httpResponseCode = http.POST(postData);

    // Cek respons dari server
    if (httpResponseCode > 0) {
      String response = http.getString();
      Serial.println("Data berhasil dikirim ke server!");
      Serial.println("Respons server: " + response);
    } else {
      Serial.print("Error saat mengirim data: ");
      Serial.println(httpResponseCode);
    }

    http.end();
  } else {
    Serial.println("WiFi tidak terhubung!");
  }

  // Tunggu 10 detik sebelum pembacaan berikutnya
  delay(10000);
}