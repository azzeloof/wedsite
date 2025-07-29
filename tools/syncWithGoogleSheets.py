import mysql.connector
import gspread
from google.oauth2.service_account import Credentials
import sys
sys.path.append("..")
from db_secrets import DB_CONFIG
from spreadsheet_config import SPREADSHEET_CONFIG

# --- Google Sheets Configuration ---
# IMPORTANT: Follow these steps to get your credentials:
# 1. Go to the Google Cloud Console: https://console.cloud.google.com/
# 2. Create a new project or select an existing one.
# 3. Enable the Google Drive API and Google Sheets API.
# 4. Create a service account.
# 5. Download the JSON key file for the service account.
# 6. Rename the JSON key file to "service_account.json" and place it in the same directory as this script.
# 7. Share your Google Sheet with the service account's email address.

def get_db_connection():
    """Establishes a connection to the MySQL database."""
    try:
        cnx = mysql.connector.connect(**DB_CONFIG)
        print("Successfully connected to the database.")
        return cnx
    except mysql.connector.Error as err:
        print(f"Database error: {err}")
        sys.exit(1)

def fetch_guest_data(cnx):
    """Fetches all data from the guests table."""
    try:
        cursor = cnx.cursor(dictionary=True)
        cursor.execute("SELECT * FROM guests ORDER BY last_name_1, first_name_1")
        data = cursor.fetchall()
        print(f"Fetched {len(data)} rows from the database.")
        return data
    except mysql.connector.Error as err:
        print(f"Error fetching data: {err}")
        return []
    finally:
        cursor.close()

def update_google_sheet(data):
    """Updates a Google Sheet with the given data."""
    if not data:
        print("No data to update in Google Sheets.")
        return

    try:
        # Authenticate with Google
        scopes = ["https://www.googleapis.com/auth/spreadsheets", "https://www.googleapis.com/auth/drive"]
        creds = Credentials.from_service_account_file("service_account.json", scopes=scopes)
        client = gspread.authorize(creds)

        # Open the spreadsheet and select the worksheet
        spreadsheet = client.open(SPREADSHEET_CONFIG['GOOGLE_SHEET_NAME'])
        worksheet = spreadsheet.worksheet(SPREADSHEET_CONFIG['WORKSHEET_NAME'])
        print(f"Successfully opened worksheet '{SPREADSHEET_CONFIG['WORKSHEET_NAME']}' in spreadsheet '{SPREADSHEET_CONFIG['GOOGLE_SHEET_NAME']}'.")


        # Clear the worksheet
        worksheet.clear()
        print("Cleared the worksheet.")

        # Write the header row
        header = list(data[0].keys())
        worksheet.append_row(header)
        print("Wrote header row to the worksheet.")

        # Write the data rows
        rows = [list(row.values()) for row in data]
        for row in rows:
            for i, cell in enumerate(row):
                if hasattr(cell, 'isoformat'): # Check if it's a date/datetime object
                    row[i] = cell.isoformat()
        worksheet.append_rows(rows)
        print(f"Wrote {len(rows)} data rows to the worksheet.")

        print("Google Sheet update complete.")

    except FileNotFoundError:
        print("Error: service_account.json not found. Please follow the instructions to set up your credentials.")
    except gspread.exceptions.SpreadsheetNotFound:
        print(f"Error: Spreadsheet '{SPREADSHEET_CONFIG['GOOGLE_SHEET_NAME']}' not found. Please check the name and make sure you have shared it with the service account.")
    except gspread.exceptions.WorksheetNotFound:
        print(f"Error: Worksheet '{SPREADSHEET_CONFIG['WORKSHEET_NAME']}' not found. Please check the name.")
    except Exception as e:
        print(f"An unexpected error occurred: {e}")

def main():
    """Main function to run the script."""
    db_connection = get_db_connection()
    guest_data = fetch_guest_data(db_connection)
    db_connection.close()
    print("Database connection closed.")

    if guest_data:
        update_google_sheet(guest_data)

if __name__ == "__main__":
    main()