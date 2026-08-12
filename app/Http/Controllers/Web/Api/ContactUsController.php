<?php

namespace App\Http\Controllers\Web\Api;

use App\Http\Controllers\Controller;
use App\Models\SiteMessage;
use App\Traits\apiresponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactUsController extends Controller
{
    use apiresponse;
    // Contact Us
    public function contactUs(Request $request) {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'nullable',
            'message' => 'required',
        ]);
        if ($validate->fails()) {
            return $this->error($validate->errors(), 'Validation Error', 422);
        }
        $data = $request->all();
        $data['subject'] = 'Message from ' . $data['name'];
        $data['created_at'] = now();

        $msg = SiteMessage::create($data);

        if (!$msg) {
            return $this->error('Failed to send message', 'Error', 500);
        }

        return $this->success($msg, 'Successfully!', 200);
    }
}
