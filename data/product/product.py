import csv
import random
import requests
import time

header = [
    "name",
    "description",
    "album",
    "product_type",
    "excerpt",
    "meta_title",
    "meta_description",
    "canonical",
    "attributes",
    "variants",
    "image",
    "brand_id",
    "product_catalogue_id",
    "cost_price",
    "price",
    "sale_price",
    "weight",
    "length",
    "width",
    "height",
    "shipping_ids",
    "upsell_ids",
    "variable",
]


token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL3YxL2F1dGgvbG9naW4iLCJpYXQiOjE3MjkwMDAzMTQsImV4cCI6MTczMTU5MjMxNCwibmJmIjoxNzI5MDAwMzE0LCJqdGkiOiJsanNVTm4xMHVTN2xEOG1jIiwic3ViIjoiMSIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.LMPWp0MHegTQf4hQQY4IrpM-2b45azP5954pqGRVyOY"


def call_api(payload):
    headers = {"Authorization": f"Bearer {token}", "Content-Type": "application/json"}
    response = requests.post(
        "http://127.0.0.1:8000/api/v1/products", json=payload, headers=headers
    )
    if response.status_code == 200:
        print("API call successful!")
    else:
        print(f"Request failed with status code: {response.status_code}")


price = random.randint(2999999, 39999999)
sale_price = price - random.randint(1000000, 2000000)
cost_price = price - random.randint(1000000, 2000000)


# Create dummy data for 200 products
data = []
for i in range(200):
    payload = {
        "name": f"Điện thoại Apple iPhone {i+1}",
        "description": f"Mô tả sản phẩm Apple iPhone {i + 1}",
        "album": '["http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-xanh-thumbn-600x600jpg_66e40e50df76a.webp","http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-blue-1-1jpg_66e40e50bc849.webp","http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-blue-2-1jpg_66e40e5098d1a.webp","http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-blue-3-1jpg_66e40e507d5aa.webp","http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-blue-4-1jpg_66e40e506284c.webp"]',
        "product_type": "variable",
        "excerpt": f"Điện thoại Apple iPhone {i+1} với hiệu năng vượt trội và thiết kế tinh tế.",
        "meta_title": f"Điện thoại Apple iPhone {i+1}",
        "meta_description": f"Điện thoại Apple iPhone {i+1} có thiết kế hiện đại, camera sắc nét và nhiều tính năng thông minh.",
        "canonical": f"dien-thoai-apple-iphone-{i+1}",
        "attributes": '{"enable_variation":[null,true,true,null,null,null,null],"attrIds":[null,[1,2,4],[9,10,11],[12],[23],[22],[18]],"texts":{"M\u00e0u s\u1eafc":[[1,"M\u00e0u h\u1ed3ng"],[2,"M\u00e0u t\u00edm"],[4,"M\u00e0u v\u00e0ng"]],"Dung l\u01b0\u1ee3ng ram":[[9,"128GB"],[10,"256GB"],[11,"512GB"]]}}',
        "variants": '{"variantTexts":["M\u00e0u h\u1ed3ng - 128GB","M\u00e0u h\u1ed3ng - 256GB","M\u00e0u h\u1ed3ng - 512GB","M\u00e0u t\u00edm - 128GB","M\u00e0u t\u00edm - 256GB","M\u00e0u t\u00edm - 512GB","M\u00e0u v\u00e0ng - 128GB","M\u00e0u v\u00e0ng - 256GB","M\u00e0u v\u00e0ng - 512GB"],"variantIds":["1,9","1,10","1,11","2,9","2,10","2,11","4,9","4,10","4,11"]}',
        "image": "http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-xanh-thumbn-600x600jpg_66e40e50df76a.webp",
        "brand_id": "1",
        "product_catalogue_id": ["5", "1"],
        "cost_price": cost_price,
        "price": price,
        "sale_price": "",
        "weight": "1",
        "length": "2",
        "width": "1",
        "height": "2",
        "shipping_ids": ["2", "1"],
        "upsell_ids": ["250", "249", "248", "247", "246", "245", "244"],
        "variable": [
            {
                "count": "0",
                "image": "http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-mint-1jpg_66e40e5016287.webp",
                "album": '["http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-blue-5-1jpg_66e40e5037710.webp","http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-mint-2jpg_66e40e4fe818d.webp","http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-mint-3jpg_66e40e4fca415.webp","http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-mint-4jpg_66e40e4fad5e2.webp","http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-mint-1jpg_66e40e5016287.webp"]',
                "price": "28990000",
                "sale_price": sale_price,
                "cost_price": cost_price,
            },
            {
                "count": "1",
                "image": "http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-mint-1jpg_66e40e5016287.webp",
                "album": '["http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-mint-2jpg_66e40e4fe818d.webp","http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-mint-3jpg_66e40e4fca415.webp","http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-mint-4jpg_66e40e4fad5e2.webp","http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-mint-1jpg_66e40e5016287.webp"]',
                "price": "28990000",
                "cost_price": cost_price,
            },
            {
                "count": "2",
                "image": "http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-mint-1jpg_66e40e5016287.webp",
                "album": '["http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-mint-1jpg_66e40e5016287.webp","http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-mint-2jpg_66e40e4fe818d.webp","http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-mint-3jpg_66e40e4fca415.webp","http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-mint-4jpg_66e40e4fad5e2.webp"]',
                "price": "28990000",
                "cost_price": cost_price,
            },
            {
                "count": "3",
                "image": "http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-mint-1jpg_66e40e5016287.webp",
                "album": '["http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-mint-1jpg_66e40e5016287.webp","http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-mint-2jpg_66e40e4fe818d.webp","http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-mint-3jpg_66e40e4fca415.webp","http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-mint-4jpg_66e40e4fad5e2.webp"]',
                "price": price,
                "sale_price": sale_price,
                "cost_price": cost_price,
            },
            {
                "count": "4",
                "image": "http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-mint-1jpg_66e40e5016287.webp",
                "album": '["http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-mint-1jpg_66e40e5016287.webp","http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-mint-2jpg_66e40e4fe818d.webp","http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-mint-3jpg_66e40e4fca415.webp","http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-mint-4jpg_66e40e4fad5e2.webp"]',
                "price": price,
                "cost_price": cost_price,
            },
            {
                "count": "5",
                "image": "http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-yellow-1jpg_66e40e4f8ab30.webp",
                "album": '["http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-yellow-1jpg_66e40e4f8ab30.webp","http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-yellow-2jpg_66e40e4f67278.webp","http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-yellow-3jpg_66e40e4f4a43b.webp","http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-yellow-4jpg_66e40e4f2d7a5.webp","http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-yellow-5jpg_66e40e4f01afe.webp"]',
                "price": price,
                "cost_price": cost_price,
            },
            {
                "count": "6",
                "image": "http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-yellow-1jpg_66e40e4f8ab30.webp",
                "album": '["http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-yellow-1jpg_66e40e4f8ab30.webp","http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-yellow-2jpg_66e40e4f67278.webp","http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-yellow-3jpg_66e40e4f4a43b.webp","http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-yellow-4jpg_66e40e4f2d7a5.webp","http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-yellow-5jpg_66e40e4f01afe.webp"]',
                "price": price,
                "cost_price": cost_price,
            },
            {
                "count": "7",
                "image": "http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-yellow-1jpg_66e40e4f8ab30.webp",
                "album": '["http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-yellow-1jpg_66e40e4f8ab30.webp","http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-yellow-2jpg_66e40e4f67278.webp","http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-yellow-3jpg_66e40e4f4a43b.webp","http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-yellow-4jpg_66e40e4f2d7a5.webp","http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-yellow-5jpg_66e40e4f01afe.webp"]',
                "price": price,
                "sale_price": sale_price,
                "cost_price": cost_price,
            },
            {
                "count": "8",
                "image": "http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-yellow-1jpg_66e40e4f8ab30.webp",
                "album": '["http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-yellow-1jpg_66e40e4f8ab30.webp","http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-yellow-2jpg_66e40e4f67278.webp","http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-yellow-3jpg_66e40e4f4a43b.webp","http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-yellow-4jpg_66e40e4f2d7a5.webp","http:\/\/127.0.0.1:8000\/images\/2024\/09\/samsung-galaxy-z-flip6-yellow-5jpg_66e40e4f01afe.webp"]',
                "price": price,
                "sale_price": sale_price,
                "cost_price": cost_price,
            },
        ],
    }

    call_api(payload)

    wait_time = random.uniform(1, 5)
    print(f"Waiting for {wait_time:.2f} seconds before next call...")
    time.sleep(wait_time)

# Write the data to a CSV file
# file_path = "products.csv"
# with open(file_path, mode="w", newline="", encoding="utf-8") as file:
#     writer = csv.DictWriter(file, fieldnames=header)
#     writer.writeheader()
#     writer.writerows(data)

# file_path

print("Done!")
