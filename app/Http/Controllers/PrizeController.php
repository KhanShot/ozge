<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;

class PrizeController extends Controller
{
    public function getPrizes()
    {
        $data = Cache::remember('active_products', 60*60*24 ,function () {
            return Products::query()->where('is_active', 1)->get()->transform(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'value' => $item->description,
                    'bgColor' => $item->bgColor,
                    'color' => $item->color,
                    'probability' => (int)$item->probability,
                ];
            });
        });
        return $data;
    }
    public function checkPrize(Request $request){
        $client = Clients::query()->where('promo', $request->get('promo'))
            ->where('is_used', 0)
            ->whereNull('used_date')
            ->whereNull('product_id')
            ->first();
        if ($client){
            return response()->json(['is_valid' => true, 'msg' => null], 200);
        }else{

            $used = Clients::query()->where('promo', $request->get('promo'))
                ->where('is_used', 1)
                ->first();
            if ($used)
                return response()->json(['is_valid' => false, 'msg' => 'Вы уже использовали промокод, если нет, обратитесь в менеджеров!'], 400);

            return response()->json(['is_valid' => $used, 'msg' => 'Промокод не найден!'], 400);
        }
    }

    public function assignPrize(Request $request)
    {
        $data = json_decode(decrypt($request->get('payload'), unserialize: false));

        $prize = Products::query()->find($data->id);
        if (!$prize)
            return response()->json(['is_valid' => false, 'msg' => 'Ошибка с призом, попробуйте снова или свяжитесь с менеджером'], 400);

        $client = Clients::query()->where('promo', $data->promo)->first();
        if (!$client)
            return response()->json(['is_valid' => false, 'msg' => 'Ошибка с Промокодом, попробуйте снова или свяжитесь с менеджером'], 400);

        $client->is_used = true;
        $client->used_date = now();
        $client->product_id = $prize->id;

        $client->save();

        return response()->json(['is_valid' => true, 'msg' => null], 200);
    }

}
