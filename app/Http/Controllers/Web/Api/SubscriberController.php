<?php

namespace App\Http\Controllers\Web\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use App\Traits\apiresponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriberController extends Controller
{
    use apiresponse;
    // Subscribe
    public function subscribeUs(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors(), 'Validation Error', 422);
        }
        $data = $request->all();
        $data['created_at'] = now();
        $sub = Subscriber::create($data);
        if (!$sub) {
            return $this->error('Failed to subscribe', 'Error', 500);
        }
        return $this->success($sub, 'Successfully Subscribed! If you like to unsubscribe, please contact us from contact us page on our website. Thanks you!', 200);
    }
}
