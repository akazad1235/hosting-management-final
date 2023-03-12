<?php
namespace App\Traits;

use Illuminate\Support\Facades\Storage;


trait ImagesTrait{

    public function uploadImage($file='', $path='', $existFileName=''){
        if($path =='' && $file==''){
            throw new \Exception('uploadImage func argument pass file/path');
        }
      // $file = $file->file('image');
      //  $filename = $file->getClientOriginalName();

      //  $fileName =  time().'.'.$file->getClientOriginalName();

        $fileName = rand(0, 999999999) . '_' . date('Ymdhis').'_' . rand(100, 999999999) . '.' . $file->getClientOriginalExtension();

        $file->storeAs("public/{$path}/", $fileName);
       // $file->move(public_path("{$path}/", $fileName));

     //   $img = Image::make($file)->fit(400)->encode();
     //   $fileName = rand(0, 999999999) . '_' . date('Ymdhis').'_' . rand(100, 999999999) . '.' . $file->getClientOriginalExtension();
     //   Storage::put($fileName, $img);//Put file with own name
      // Storage::move($fileName, "{$path}/{$fileName}");//Move file to your location

        $imagePath = public_path("storage/{$existFileName}");
        if (!empty($existFileName) && file_exists($imagePath)){
            unlink($imagePath);
        }
        return "{$path}/{$fileName}";
    }
    //image unlink from storage when every image row delete
    public function deleteImage($existFileName=''){
        try {
            $imagePath = public_path("storage/{$existFileName}");
            if (!empty($existFileName) && file_exists($imagePath)){
                unlink($imagePath);
            }
        }catch (\Exception $ex){
            return $ex->getMessage();
        }

    }
    private function defaultImagePath(){
        return asset('images/default-image.png');
    }

    public function uploadMultipleImage($files='', $path='', $existFileName=''){
        $arr = [];
        foreach ($files as $file){

          //  $fileName =  time().'.'.$file->getClientOriginalName();
            // $request->file('image')->storeAs('images', $fileName);
            $fileName = rand(0, 999999999) . '_' . date('Ymdhis').'_' . rand(100, 999999999) . '.' . $file->getClientOriginalExtension();
            $file->storeAs("{$path}/", $fileName);



            $path = "{$path}/{$fileName}";
            array_push($arr, $path);

        }
        return json_encode($arr);
    }

}

?>
