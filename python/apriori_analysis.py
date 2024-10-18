import pandas as pd
from apyori import apriori
import redis
import json

# Kết nối đến Redis
r = redis.Redis(host="127.0.0.1", port=6379, db=0)

chunk_size = 10000
transactions = []
path_file = "../laravel/public/orders.csv"

# Đọc file CSV theo từng khối
for chunk in pd.read_csv(path_file, chunksize=chunk_size):
    chunk_transactions = (
        chunk["product_variant_ids"].apply(lambda x: x.split(",")).tolist()
    )
    transactions.extend(chunk_transactions)

# Áp dụng thuật toán Apriori
results = list(apriori(transactions, min_support=0.2, min_confidence=0.6))

# Lưu kết quả vào Redis dưới dạng JSON
for result in results:
    # Chuyển đổi kết quả thành dict trước khi chuyển sang JSON
    result_dict = {
        "items": list(result.items),  # Chuyển frozenset thành list
        "support": result.support,
        "ordered_statistics": [
            {
                "items_base": list(stat.items_base),  # Chuyển frozenset thành list
                "items_add": list(stat.items_add),  # Chuyển frozenset thành list
                "confidence": stat.confidence,
                "lift": stat.lift,
            }
            for stat in result.ordered_statistics
        ],
    }
    json_result = json.dumps(result_dict)  # Chuyển đổi thành JSON
    r.rpush("laravel_database_apriori_suggest_product", json_result)  # Đẩy vào Redis

print("Apriori results saved to Redis.")
