import csv
import random
import mysql.connector
import sys
sys.path.append("..")
from db_secrets import DB_CONFIG

guests = []

with open('guests.csv', 'r') as file:
    reader = csv.DictReader(file)
    for row in reader:
        if not row['Name'].endswith('?'):
            guests.append(row)

CODE_LENGTH = 4
# Characters to use for codes (avoiding ambiguous I, l, 1, O, 0)
CODE_CHARS = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789"

def generate_unique_code(length, existing_codes):
    while True:
        code = ''.join(random.choice(CODE_CHARS) for _ in range(length))
        if code not in existing_codes:
            existing_codes.add(code)
            return code

def main():
    generated_guests_data = []
    existing_codes = set()

    print("Generating codes for guests...")
    for guest_info in guests:
        # this parser is very lazy. It assumes that there are no spaces in names (other than between first and last)
        names_string = guest_info['Name']
        names = names_string.split('&')
        if len(names) == 0:
            print("error: " + names_string)
        elif len(names) == 1:
            name_split = names[0].strip().split(' ')
            first_name_1 = name_split[0].replace('_', ' ')
            last_name_1 = name_split[1].replace('_', ' ')
            first_name_2 = None
            last_name_2 = None
        elif len(names) == 2:
            name_1_split = names[0].strip().split(' ')
            first_name_1 = name_1_split[0].replace('_', ' ')
            last_name_1 = name_1_split[1].replace('_', ' ')
            name_2_split = names[1].strip().split(' ')
            first_name_2 = name_2_split[0].replace('_', ' ')
            last_name_2 = name_2_split[1].replace('_', ' ')
        else:
            print("error: " + names_string)
        code = generate_unique_code(CODE_LENGTH, existing_codes)
        generated_guests_data.append({
            'last_name_1': last_name_1,
            'first_name_1': first_name_1,
            'last_name_2': last_name_2,
            'first_name_2': first_name_2,
            'rsvp_code': code,
            'plus_ones_allowed': guest_info.get('Offer +1?', 0) == 'Yes',
            'has_rsvpd': False # Default
        })
        print(f" {guest_info['Name']}: {code}")

    try:
        cnx = mysql.connector.connect(**DB_CONFIG)
        cursor = cnx.cursor()
        
        # Clear existing guests if you want to rerun (be careful!)
        # cursor.execute("DELETE FROM guests") 
        # print("Cleared existing guests from table.")

        insert_query = """
        INSERT INTO guests (last_name_1, first_name_1, last_name_2, first_name_2, rsvp_code, plus_ones_allowed, has_rsvpd)
        VALUES (%(last_name_1)s, %(first_name_1)s, %(last_name_2)s, %(first_name_2)s, %(rsvp_code)s, %(plus_ones_allowed)s, %(has_rsvpd)s)
        """
        
        for record in generated_guests_data:
            cursor.execute(insert_query, record)
        
        cnx.commit()
        print(f"\nSuccessfully inserted {cursor.rowcount} guests into the database.")

    except mysql.connector.Error as err:
        print(f"Database error: {err}")
    finally:
        if 'cnx' in locals() and cnx.is_connected():
            cursor.close()
            cnx.close()
            print("Database connection closed.")

if __name__ == '__main__':
    main()