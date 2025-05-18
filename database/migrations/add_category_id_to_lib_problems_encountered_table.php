use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryIdToLibProblemsEncounteredTable extends Migration
{
    public function up()
    {
        Schema::table('lib_problems_encountered', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable()->after('encountered_problem_name');
            $table->foreign('category_id')->references('id')->on('lib_categories')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('lib_problems_encountered', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
}
