<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\File;
use App\Http\Controllers\HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Support\Facades\Http;
class HelpController extends Controller
{
    protected $s3;
    public function __construct( )
    {
        $this->s3 = ".s3.";
        
    }
    public static function loai_giaodich($doc_type)
    {
        
        switch ($doc_type) {
            case 'din':
                $msg = 'nhập hủy';
                break;
            case 'dout':
                $msg = 'xuất hủy';
                break;
            case 'wi':
                $msg = 'nhập';
                break;
            case 'wo':
                $msg = 'xuất';
                break;
            case 'ic':
                $msg = 'kiểm kho';
                break;
            case 'mi':
                $msg =  'Phiếu chuyển kho bảo hành';
                break;
            case 'wm':
                $msg =  'Kho bán chuyển kho bảo hành';
                break;
            case 'wd':
                $msg =  'Kho bán chuyển kho hủy';
                break;
            case 'wp':
                $msg =  'Kho bán chuyển kho tài sản';
                break;
            case 'pi':
                $msg =  'Kho tài sản chuyển kho bán';
                break;
            case 'ti':
                $msg = 'chuyển kho';
                break;
            case 'co':
                $msg = 'tạo combo';
                break;
            case 'wir':
                $msg = 'trả hàng nhập';
                break;
            default:
                $msg =  $doc_type;
                break;
        }
        return $msg;
    }
    public static function url_giaodich($doc_type,$doc_id)
    {
        
        switch ($doc_type) {
            case 'din':
                $msg =  route('warehousein.showold',$doc_id);
                break;
            case 'dout':
                $msg =  route('warehouseout.showold',$doc_id);
                break;
            case 'wi':
                $msg =   route('warehousein.show',$doc_id);
                break;
            case 'wir':
                $msg =   route('warehousein.show',$doc_id);
                break;
            case 'wo':
                $msg =  route('warehouseout.show',$doc_id);
                break;
            case 'ic':
                $msg = route('inventorycheck.show',  $doc_id);
                break;
            case 'mi':
                $msg =  '#';
                break;
            case 'wm':
                $msg =  '#';
                break;
            case 'wd':
                $msg =  '#';
                break;
            case 'wp':
                $msg =  '#';
                break;
            case 'pi':
                $msg =  '#';
                break;
            case 'ti':
                $msg = route('warehousetransfer.show',$doc_id);
                break;
            case 'co':
                $msg = route('combocreation.show',$doc_id);
                break;
            default:
                $msg =   '#';
                break;
        }
        return $msg;
    }
    public function send_invoice($wo_id,$uiid)
    {
        $detail = \App\Models\SettingDetail::find(1);
        
        $tokenResponse = Http::post('https://itcctv.vn/api/v1/login', [
            'email' =>  $detail->itcctv_email ,
            'password' =>$detail->itcctv_pass,
        ]);
        // dd($tokenResponse->body() );
        if (!$tokenResponse->successful()) {
            return response()->json(['error' => 'Failed to get token'], 500);
        }
    
        $accessToken = $tokenResponse->json()['token']['token'];
        // dd($accessToken );
        $response = Http::withToken($accessToken)
                    ->post('https://itcctv.vn/api/v1/store_invoice', [
                        'wo_id' => $wo_id,
                        'uiid' => $uiid,
                        // Add other POST data as needed
                    ]);
        
        // Check response status and handle errors
        if ($response->failed()) {
           
            echo $response->status();
            echo $response->body();
            // Handle error accordingly
        }
        // dd( $response->body());
        $responseData = "";
        if ($response->successful()) {
            // Request was successful, handle response
            $responseData = $response->json();
            // echo 'thành cong <br/>';
            // return $response->json();
        }
        if ($responseData != "")
        {
           
            return $responseData['success'];
        }
        else
            return null;
    }
    public function store_invoice($uiid)
    {
        $detail = \App\Models\SettingDetail::find(1);
        
        $tokenResponse = Http::post('https://itcctv.vn/api/v1/login', [
            'email' =>  $detail->itcctv_email ,
            'password' =>$detail->itcctv_pass,
        ]);
        // dd($tokenResponse->body() );
        if (!$tokenResponse->successful()) {
            return response()->json(['error' => 'Failed to get token'], 500);
        }
    
        $accessToken = $tokenResponse->json()['token']['token'];
        // dd($accessToken );
        $response = Http::withToken($accessToken)
                    ->post('https://itcctv.vn/api/v1/get_invoice', [
                        'uiid' => $uiid,
                        // Add other POST data as needed
                    ]);
        
        // Check response status and handle errors
        if ($response->failed()) {
           
            echo $response->status();
            echo $response->body();
            // Handle error accordingly
        }
        // dd( $response->body());
        $responseData = "";
        if ($response->successful()) {
            // Request was successful, handle response
            $responseData = $response->json();
            // echo 'thành cong <br/>';
            // return $response->json();
        }
        if ($responseData != "")
        {
           
          return $responseData;
        }
        else
            return null;
    }
    public function get_detailproduct($id)
    {
         
        $detail = \App\Models\SettingDetail::find(1);
        if (!session('token_itcctv'))
        {
            $tokenResponse = Http::post('https://itcctv.vn/api/v1/login', [
                'email' =>  $detail->itcctv_email ,
                'password' =>$detail->itcctv_pass,
            ]);
            // dd($tokenResponse->body() );
            if (!$tokenResponse->successful()) {
                return response()->json(['error' => 'Failed to get token'], 500);
            }
        
            $accessToken = $tokenResponse->json()['token']['token'];
            session('token_itcctv',$accessToken);
        }
        else
            $accessToken = session('token_itcctv');
        // dd($accessToken );
        $response = Http::withToken($accessToken)
                    ->post('https://itcctv.vn/api/v1/get_product_detail', [
                        'id' => $id,
                        // Add other POST data as needed
                    ]);
        // return $response;
        // Check response status and handle errors
        if ($response->failed()) {
        
            echo $response->status();
            echo $response->body();
            // Handle error accordingly
        }
        // dd( $response->body());
        $responseData = "";
        if ($response->successful()) {
            // Request was successful, handle response
            $responseData = $response->json();
            // echo 'thành cong <br/>';
            // return $response->json();
        }

        if ($responseData != "")
        {
        //   dd($responseData) ;
            $product = $responseData['product'];
            $product = json_decode($product);
            return response()->json([
                'status' => true,
                'product' => json_encode($product),
            ], 200);
        }
        else
            return null;
    }
    public function get_products($searchdata)
    {
    
        if(strlen( $searchdata) < 3)
            return;
        // dd($searchdata);
        $detail = \App\Models\SettingDetail::find(1);
        if (!session('token_itcctv'))
        {
            $tokenResponse = Http::post('https://itcctv.vn/api/v1/login', [
                'email' =>  $detail->itcctv_email ,
                'password' =>$detail->itcctv_pass,
            ]);
            // dd($tokenResponse->body() );
            if (!$tokenResponse->successful()) {
                return response()->json(['error' => 'Failed to get token'], 500);
            }
        
            $accessToken = $tokenResponse->json()['token']['token'];
            session('token_itcctv',$accessToken);
        }
        else
            $accessToken = session('token_itcctv');
        // dd($accessToken );
        $response = Http::withToken($accessToken)
                    ->post('https://itcctv.vn/api/v1/get_product_jsearch', [
                        'searchdata' => $searchdata,
                        // Add other POST data as needed
                    ]);
        // return $response;
        // Check response status and handle errors
        if ($response->failed()) {
           
            echo $response->status();
            echo $response->body();
            // Handle error accordingly
        }
        // dd( $response->body());
        $responseData = "";
        if ($response->successful()) {
            // Request was successful, handle response
            $responseData = $response->json();
            // echo 'thành cong <br/>';
            // return $response->json();
        }

        if ($responseData != "")
        {
        //   dd($responseData) ;
            $products = $responseData['products'];
            $products = json_decode($products);
            return response()->json([
                'status' => true,
                'products' => json_encode($products),
            ], 200);
        }
        else
            return null;
    }
    public function uploadImageInContent($content)
    {
         
        $pattern = '/<img[^>]+src="([^"]+)"/';
        $modified_html = preg_replace_callback($pattern, function($matches) {
            // Perform upload action for each image
            $substring = $this->s3;
            
            if (strpos($matches[1], $substring) !== false) 
            {
                return $matches[0];
            }
            else
            {
                // dd($matches[1]);
                $fileController = new \App\Http\Controllers\FilesController();
                $uploadedImagePath = $fileController->blogimageUpload($matches[1]);
                // dd ( $uploadedImagePath);
                // Replace original src attribute with uploaded image link
                return str_replace($matches[1], $uploadedImagePath, $matches[0]);
            }
        
        }, $content);
        return  $modified_html;
    }
    public function removeImageStyle($content)
    {
        $modified_html = preg_replace_callback('/<img[^>]*>/', function($match) {
            return preg_replace('/\s*style\s*=\s*("[^"]*"|\'[^\']*\')/', '', $match[0]);
             
        }, $content);
        return  $modified_html ;
    }
}