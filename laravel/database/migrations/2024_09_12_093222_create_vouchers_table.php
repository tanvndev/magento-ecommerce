<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 50)->unique();
            $table->string('image')->nullable();
            $table->string('description')->nullable();
            $table->string('value_type', 20);
            $table->decimal('value', 15, 2);
            $table->decimal('value_limit_amount', 15, 2)->nullable();
            $table->unsignedInteger('quantity')->nullable();
            $table->string('condition_apply', 50)->nullable()->comment('Điều kiện áp dụng');
            $table->decimal('subtotal_price', 15, 2)->nullable()->comment('Tổng giá trị đơn hàng tối thiểu');
            $table->unsignedSmallInteger('min_quantity')->nullable()->comment('Tổng số lượng sản phẩm được khuyến mại tối thiểu');
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->tinyInteger('publish')->default(1)->comment('1:Active, 2: Inactive');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
