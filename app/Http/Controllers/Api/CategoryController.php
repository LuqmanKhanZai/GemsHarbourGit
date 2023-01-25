<?php



namespace App\Http\Controllers\Api;



use App\Models\Category;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;



class CategoryController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        try{

            $category     = Category::active()->withCount('product')->get();

            return response()->json([

                'data'        => $category,

                'status'      => 200,

                'message'     => 'All Category List',

            ]);

        }catch (\Exception $e) {

            return response()->json([

                'status'  => 500,

                'message' => 'Request Failed',

                'server_error' => $e->getMessage(),

            ]);

        }

    }



    public function random()
    {
        try{
            $category = Category::active()
            ->limit(4)->with('random_product.images')->get();
            // $category = Category::active()->inRandomOrder()
            // ->limit(4)->with('random_product.images')->get();

            // $category = Category::active()->limit(4)->with('random_product.images')->whereHas('random_product', function($q) {
            //     $q->where('status', 'Active');
            //    })->get();
            return response()->json([
                'data'        => $category,
                'status'      => 200,
                'message'     => 'Random Category List',
            ]);
        }catch (\Exception $e) {
            return response()->json([
                'status'  => 500,
                'message' => 'Request Failed',
                'server_error' => $e->getMessage(),
            ]);
        }
    }





    public function CategoryProduct($id)

    {

        try{

            $category   = Category::active()->where('id',$id)->with('product.images')->get();

            return response()->json([

                'data'        => $category,

                'status'      => 200,

                'message'     => 'Category Aginst Product'

            ]);

        }catch (\Exception $e) {

            return response()->json([

                'status'  => 500,

                'message' => 'Request Failed',

                'server_error' => $e->getMessage()

            ]);

        }

    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        //

    }



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        //

    }



    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {

        //

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        //

    }



    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, $id)

    {

        //

    }



    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        //

    }

}

