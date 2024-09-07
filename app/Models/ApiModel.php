<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;

// Now all the models extends from this ApiModel class
class ApiModel extends Model
{
    // Nothing here


    protected static function map($array) {
        $class = get_called_class();

        try {

            if(is_array($array)) {
                $array = collect($array);
            }

            //instance created from the php standard class
            if(get_class($array)==\stdClass::class) {
                $array=collect([$array]);
            }

            //fill the collection
            return $array->map(function($item) use ($class) {
                $object = new $class();

                //fill with fillables
                foreach ($object->fillable as $key) {
                    try {
                        $object->$key = $item->$key;
                    } catch(\Exception$e) {
                        echo $e->getMessage();
                        dd($item);
                    }
                }

                return $object;

            });


        } catch(\Exception$e) {
            echo $e->getMessage();
            exit;
        }
    }

    /**
     * @return Collection|void
     */
    public static function all($columns = null)
    {
        $childClass = get_called_class();
        $shortClassName = substr($childClass, strrpos($childClass, '\\') + 1);
        $response=self::getWithToken(strtolower($shortClassName),$columns);
        return $response;
    }

    public static function find($id){
        $childClass = get_called_class();
        $shortClassName = substr($childClass, strrpos($childClass, '\\') + 1);
        $model = strtolower($shortClassName);
        $response = self::getWithToken($model.'/'.$id);
        return $response;
    }

    public static function create(array $attributes = [], array $options = [])
    {
        $childClass = get_called_class();
        $shortClassName = substr($childClass, strrpos($childClass, '\\') + 1);
        $model = strtolower($shortClassName);
        return self::postWithToken($model,$attributes);
    }

    public static function destroy($id)
    {
        $childClass = get_called_class();
        $shortClassName = substr($childClass, strrpos($childClass, '\\') + 1);
        $model = strtolower($shortClassName);
        return self::deleteWithToken($model,$id);
    }

    public function update(array $attributes = [], array $options = [])
    {
        $childClass = get_called_class();
        $shortClassName = substr($childClass, strrpos($childClass, '\\') + 1);
        $model = strtolower($shortClassName);
        return self::putWithToken($model.'/'.$this->id,$attributes);
    }

    public static function maj(int $id, array $attributes = [], array $options = [])
    {
        $childClass = get_called_class();
        $shortClassName = substr($childClass, strrpos($childClass, '\\') + 1);
        $model = strtolower($shortClassName);
        return self::putWithToken($model.'/'.$id,$attributes);
    }


    public function resolveRouteBinding($value, $field = null)
    {
        return self::find($value);
    }


    public static function post($route, $formParams)
    {
        $response = Http::post(config('api.url').'/'.$route,$formParams);
        return json_decode($response->body());
    }

    public static function getWithToken($route, $urlParams=null)
    {
        $response = Http::withToken(Session::get('api_token'))->get(config('api.url').'/'.$route,$urlParams);
        return json_decode($response->body());
    }

    public static function postWithToken($route, $formParams)
    {
        $response = Http::withToken(Session::get('api_token'))->post(config('api.url').'/'.$route,$formParams);
        return json_decode($response->body());
    }

    public static function putWithToken($route, $putParams)
    {
        $response = Http::withToken(Session::get('api_token'))->put(config('api.url').'/'.$route,$putParams);
        return json_decode($response->body());
    }

    public static function deleteWithToken($route, $deleteParams)
    {
        $response = Http::withToken(Session::get('api_token'))->delete(config('api.url').'/'.$route,$deleteParams);
        return json_decode($response->body());
    }
}
