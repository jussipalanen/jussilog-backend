Original file line number	Diff line number	Diff line change
 <?php
 use Illuminate\Database\Migrations\Migration;
 use Illuminate\Database\Schema\Blueprint;
 use Illuminate\Support\Facades\Schema;
 return new class extends Migration
 {
     /**
      * Run the migrations.
      *
      * @return void
      */
     public function up(): void
     {
         Schema::table('resumes', function (Blueprint $table): void {
             $table->boolean('is_primary')
                 ->default(false)
                 ->index();
         });
     }
     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down(): void
     {
         Schema::table('resumes', function (Blueprint $table): void {
             $table->dropIndex(['is_primary']);
             $table->dropColumn('is_primary');
         });
     }
 };