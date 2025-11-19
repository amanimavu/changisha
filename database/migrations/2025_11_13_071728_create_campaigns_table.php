<?php

use App\Enum\Privacy;
use App\Enum\Status;
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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->tinyText("title");
            $table->text("description");
            $table->date("start_date");
            $table->date("end_date");
            $table->decimal('goal', total: 8, places: 2);
            $table->decimal('funds_raised', total: 8, places: 2)->default(0.00);
            $table->enum("status", Status::cases())->default(Status::pending);
            $table->string("campaign_image", 150); //we are using url of uploaded images
            $table->integer("paybill_number");
            $table->enum("privacy", Privacy::cases())->default(Privacy::public);
            $table->boolean("verified")->default(0);

            $table->foreignId("category_id")->constrained();
            $table->foreignId("fundraiser_id")->constrained();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
