<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Lấy danh sách sản phẩm theo nhãn hiệu (brand_id).
     */
    public function getProductBrand(Request $request)
    {
        // Kiểm tra hợp lệ của 'brand_id'
        $validator = Validator::make($request->all(), [
            'brand_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Brand ID is required and must be a number',
                'errors' => $validator->errors(),
            ], 400);
        }

        // Tìm nhãn hiệu theo brand_id
        $brand = Brand::find($request->brand_id);
        if (!$brand) {
            return response()->json([
                'success' => false,
                'message' => 'Brand not found!',
            ], 404);
        }

        // Lấy sản phẩm của nhãn hiệu
        $products = Product::where('brand_id', $brand->id)
                            ->where('status', 'active')
                            ->get();

        return response()->json([
            'success' => true,
            'products' => $products,
        ], 200);
    }

    /**
     * Lấy danh sách tất cả các nhãn hiệu có trạng thái 'active'.
     */
    public function getBrand()
    {
        $brands = Brand::where('status', 'active')->get();
        
        return response()->json([
            'success' => true,
            'brands' => $brands,
        ], 200);
    }

    /**
     * Lấy danh sách sản phẩm theo danh mục (cat_id).
     */
    // public function getProductCat(Request $request)
    // {
    //     // Kiểm tra nếu 'cat_id' không tồn tại trong request
    //     $validator = Validator::make($request->all(), [
    //         'cat_id' => 'required|numeric',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Category ID is required and must be a number',
    //             'errors' => $validator->errors(),
    //         ], 400);
    //     }

    //     // Thử lấy sản phẩm theo cat_id và trạng thái
    //     try {
    //         $products = Product::where('cat_id', $request->cat_id)
    //                             ->where('status', 'active')
    //                             ->get();

    //         return response()->json([
    //             'success' => true,
    //             'products' => $products,
    //         ], 200);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'An error occurred: ' . $e->getMessage(),
    //         ], 500);
    //     }
    // }

    /**
     * Lấy danh sách tất cả sản phẩm.
     */
    // public function getAllProductList()
    // {
    //     try {
    //         $products = Product::where('status', 'active')->get();
            
    //         return response()->json([
    //             'success' => true,
    //             'products' => $products,
    //         ], 200);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Failed to load products: ' . $e->getMessage(),
    //         ], 500);
    //     }
    // }

    /**
     * Lấy danh sách tất cả danh mục (categories).
     */
    // public function getAllcat()
    // {
    //     try {
    //         $categories = \App\Models\Category::where('status', 'active')->get();
            
    //         return response()->json([
    //             'success' => true,
    //             'categories' => $categories,
    //         ], 200);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Failed to load categories: ' . $e->getMessage(),
    //         ], 500);
    //     }
    // }
   /**
     * Lấy danh sách tất cả sản phẩm.
     */
    public function getAllProductList(Request $request)
{
    // Lấy tất cả sản phẩm trong hệ thống với phân trang
    $products = Product::paginate(20); // Lấy 10 sản phẩm mỗi lần

    // Chuyển đổi dữ liệu sản phẩm, thêm URL đầy đủ cho ảnh
    $transformedProducts = $products->getCollection()->transform(function ($product) {
        // Loại bỏ các thẻ HTML khỏi description (nếu cần)
        $cleanDescription = preg_replace('/<br\s*\/?>|<\/p>|<p>/', " ", $product->description);
        $cleanDescription = strip_tags($cleanDescription); // Loại bỏ các thẻ HTML khác nếu có
        return [
            'id' => $product->id,
            'title' => $product->title,
            'price' => $product->price,
            'description' => trim($cleanDescription),
            'photo' => url($product->photo), // Đảm bảo đường dẫn ảnh đầy đủ
        ];
    });

    // Tạo phản hồi JSON bao gồm cả thông tin phân trang
    return response()->json([
        'status' => true,
        'message' => 'Danh sách sản phẩm',
        'data' => [
            'products' => $transformedProducts,
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ],
        ],
    ]);
}

    
    /**
     * Lấy danh sách tất cả danh mục (chỉ danh mục cha, trạng thái active).
     */
    public function getAllcat(Request $request)
    {
        // Lấy tất cả danh mục có 'is_parent' = 0 và 'status' = 'active', với phân trang
        $categories = Category::where('is_parent', 0)
            ->where('status', 'active')
            ->orderBy('title', 'ASC')
            ->paginate(10); // Lấy 10 danh mục mỗi lần
    
        return response()->json([
            'status' => true,
            'message' => 'Danh sách danh mục',
            'data' => $categories,
        ]);
    }
    
    public function getProductcat(Request $request)
    {
        // Lấy 'cat_id' từ request
        $categoryId = $request->input('cat_id');
        
        if (!$categoryId) {
            return response()->json([
                'status' => false,
                'message' => 'Thiếu id danh mục.',
            ], 400);
        }
    
        // Lấy danh mục theo cat_id
        $category = Category::find($categoryId);
    
        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Danh mục không tồn tại.',
            ], 404);
        }
    
        // Lấy các sản phẩm thuộc danh mục này, với phân trang
        $products = Product::where('cat_id', $categoryId)->paginate(10); // Lấy 10 sản phẩm mỗi lần
    
        return response()->json([
            'status' => true,
            'message' => 'Danh sách sản phẩm theo danh mục',
            'data' => $products,
        ]);
    }  
    /**
 * Lấy danh sách tất cả danh mục với phân trang.
 */
public function getAllCategoryList(Request $request)
{
    // Lấy tất cả danh mục cha với trạng thái 'active' và phân trang
    $categories = Category::where('status', 'active')
        ->orderBy('title', 'ASC') // Sắp xếp theo tiêu đề
        ->paginate(10); // Số lượng danh mục mỗi lần (10)

    // Chuyển đổi dữ liệu danh mục để định dạng hoặc thêm URL đầy đủ (nếu cần)
    $transformedCategories = $categories->getCollection()->transform(function ($category) {
        return [
            'id' => $category->id,
            'title' => $category->title,
            'slug' => $category->slug, // Đường dẫn danh mục (SEO-friendly)
            'photo' => url($category->photo), // URL đầy đủ của ảnh danh mục
            'description' => $category->summary ?? '', // Mô tả ngắn
            'is_parent' => $category->is_parent,
        ];
    });

    // Tạo phản hồi JSON
    return response()->json([
        'status' => true,
        'message' => 'Danh sách danh mục',
        'data' => [
            'categories' => $transformedCategories,
            'pagination' => [
                'current_page' => $categories->currentPage(),
                'last_page' => $categories->lastPage(),
                'per_page' => $categories->perPage(),
                'total' => $categories->total(),
            ],
        ],
    ]);
}
public function addToWishlist(Request $request)
{
    // Kiểm tra hợp lệ của 'product_id'
    $validator = Validator::make($request->all(), [
        'product_id' => 'required|numeric',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Product ID is required and must be a number',
            'errors' => $validator->errors(),
        ], 400);
    }

    // Lấy thông tin người dùng đã đăng nhập
    $user = auth()->user();
    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'User not authenticated',
        ], 401);
    }

    // Kiểm tra nếu sản phẩm đã có trong danh sách yêu thích
    $existingWishlist = Wishlist::where('product_id', $request->product_id)
        ->where('user_id', $user->id)
        ->first();

    if ($existingWishlist) {
        return response()->json([
            'success' => false,
            'message' => 'Product is already in your wishlist',
        ], 400);
    }

    // Thêm sản phẩm vào danh sách yêu thích
    $wishlist = new Wishlist();
    $wishlist->user_id = $user->id;
    $wishlist->product_id = $request->product_id;
    $wishlist->save();

    return response()->json([
        'success' => true,
        'message' => 'Product added to wishlist successfully',
    ], 200);
}

public function getWishlist(Request $request)
{
    $user = auth()->user();
    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'User not authenticated',
        ], 401);
    }

    // Lấy tất cả sản phẩm trong danh sách yêu thích của người dùng
    $wishlist = Wishlist::where('user_id', $user->id)
        ->join('products', 'wishlist.product_id', '=', 'products.id')
        ->where('products.status', 'active')
        ->select('products.id', 'products.title', 'products.price', 'products.photo')
        ->get();

    return response()->json([
        'success' => true,
        'wishlist' => $wishlist,
    ], 200);
}

public function removeFromWishlist(Request $request, $product_id)
{
    $user = auth()->user();
    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'User not authenticated',
        ], 401);
    }

    // Kiểm tra nếu sản phẩm có trong danh sách yêu thích
    $wishlist = Wishlist::where('user_id', $user->id)
        ->where('product_id', $product_id)
        ->first();

    if (!$wishlist) {
        return response()->json([
            'success' => false,
            'message' => 'Product not found in your wishlist',
        ], 404);
    }

    // Xóa sản phẩm khỏi danh sách yêu thích
    $wishlist->delete();

    return response()->json([
        'success' => true,
        'message' => 'Product removed from wishlist successfully',
    ], 200);
}
}
