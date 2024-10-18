insert_statements = []

for user_id in range(1, 10):

    if user_id == 2 or user_id == 7:
        province_id = "01"
        district_id = "017"
        ward_id = "00490"
        fullname = f"Nguyen Van {chr(65 + (user_id - 19) % 26)}"
        shipping_address = "Xã Kim Nỗ, Huyện Đông Anh, Hà Nội, 36000, Việt Nam"
        phone = f"02292993{user_id - 19}"
        is_primary = 1

        sql = (
            f"INSERT INTO user_addresses (user_id, province_id, district_id, ward_id, fullname, "
            f"shipping_address, phone, is_primary) VALUES "
            f"({user_id}, '{province_id}', '{district_id}', '{ward_id}', '{fullname}', "
            f"'{shipping_address}', '{phone}', {is_primary});"
        )

        insert_statements.append(sql)

with open("insert_user_addresses.sql", "w", encoding="utf-8") as f:
    for statement in insert_statements:
        f.write(statement + "\n")

print("Đã ghi các câu lệnh INSERT vào file 'insert_user_addresses.sql'")
