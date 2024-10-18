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
    if "product_variant_ids" not in chunk.columns:
        print("Error: Column 'product_variant_ids' not found in CSV file")
        exit(1)

    chunk_transactions = (
        chunk["product_variant_ids"].dropna().apply(lambda x: x.split(",")).tolist()
    )
    transactions.extend(chunk_transactions)


# Áp dụng thuật toán Apriori với ngưỡng thấp hơn
results = list(
    apriori(
        transactions, min_support=0.002, min_confidence=0.01, min_lift=1.2, max_length=3
    )
)
print(f"Number of rules found: {len(results)}")

# Lưu kết quả vào Redis dưới dạng JSON
for result in results:
    result_dict = {
        "items": list(result.items),
        "support": result.support,
        "ordered_statistics": [
            {
                "items_base": list(stat.items_base),
                "items_add": list(stat.items_add),
                "confidence": stat.confidence,
                "lift": stat.lift,
            }
            for stat in result.ordered_statistics
        ],
    }
    # print(result_dict)
    json_result = json.dumps(result_dict)  # Chuyển đổi thành JSON
    r.rpush("laravel_database_apriori_suggest_product", json_result)  # Đẩy vào Redis

print("Apriori results saved to Redis.")
