from flask import Flask, render_template
import pandas as pd
import mysql.connector
import joblib

# Load your trained model
model = joblib.load("adc_corrector.pkl")

# MySQL connection config
db_config = {
    'host': 'localhost',
    'user': 'root',
    'password': '',
    'database': 'project'
}

app = Flask(__name__)

def get_latest_data():
    conn = mysql.connector.connect(**db_config)
    cursor = conn.cursor(dictionary=True)
    cursor.execute("SELECT * FROM readings ORDER BY id DESC LIMIT 1")
    row = cursor.fetchone()
    conn.close()
    return row

@app.route("/")
def index():
    data = get_latest_data()
    if data:
        X = pd.DataFrame([[data["active_output"], data["temperature"], data["humidity"], data["pressure"]]], columns=["active_output", "temperature", "humidity", "pressure"])
        corrected_adc = model.predict(X)[0]
        return render_template("dashboard.html", raw=data["active_output"], temp=data["temperature"], hum=data["humidity"], pres=data["pressure"], corrected=corrected_adc)
    else:
        return "No data found in database."

if __name__ == "__main__":
    app.run(host="0.0.0.0", port=5000, debug=True)
