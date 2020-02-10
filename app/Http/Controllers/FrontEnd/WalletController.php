<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use Auth;
use App\Models\Slide;
use App\Models\Code;
use App\Models\UserCodeLog;
use App\Models\Wallet;
use App\User;
use App\Models\WalletLog;
use App\Helpers\Helper;

class WalletController extends Controller
{    
    public function add()
    {
        if(!Auth::check())
        {
            return redirect()->route('home');
        }
        $user = Auth::user();
        $var = [];
        $var['user'] = $user;
        $var['user_wallet'] = Wallet::where('user_id',$user->id)->first();      
        return view('wallet.add',compact('var'));
    }
    public function addPost(Request $request)
    {
        $data = $request->all();
        if(!isset($data['code']) || empty($data['code']))
        {
            alert()->error("Bạn cần điền đầy đủ thông tin");
            return redirect()->route('user.wallet.add');
        }
        if(!Auth::check())
        {
            return redirect()->route('home');
        }
        $user = Auth::user();
        //check xem có bao nhiêu lan nap loi
        $logError = UserCodeLog::where('user_id',$user->id)->orderBy('id','DESC')->take(5)->get();
        $countError = 0;        
        foreach($logError as $error)
        {
            if($error->status == UserCodeLog::STATUS_ERROR)
            {
                $countError += 1; 
            }
        }
        if($countError >= 5)
        {
            alert()->error("Bạn đã nhập sai mã code 5 lần, tài khoản của bạn đã bị khóa");
            return redirect()->route('user.wallet.add');
        }
        //check code
        $code = Code::where('code',$data['code'])->first();
        $status = UserCodeLog::STATUS_ERROR;
        $code_id = 0;
        if($code)
        {
            $status = UserCodeLog::STATUS_OK;
            $code_id = $code->id;
            //kiem tra xem ma code con han su dung ko
            if($code->end_date < time())
            {
                alert()->error("Mã code đã hết hạn sử dụng, bạn vui lòng sử dụng mã code khác");
                return redirect()->route('user.wallet.add');
            }
            //kiem tra xem ma code co ai su dung chua
            if($code->status == Code::STATUS_OFF)
            {
                alert()->error("Mã code đã được sử dụng, bạn vui lòng sử dụng mã code khác");
                return redirect()->route('user.wallet.add');
            }
        }
        $log = new UserCodeLog();
        $log->user_id = $user->id;
        $log->code_id = $code_id;
        $log->code = $data['code'];
        $log->status = $status;
        $log->create_at = time();
        $log->save();
        if($status == UserCodeLog::STATUS_ERROR)
        {
            //khoa tai khoan user, do nhap sai qua 5 lan
            if($countError >= 4)
            {
                $user->status = User::STATUS_BLOCK;
                $user->save();
                alert()->error("Bạn đã nhập sai mã code 5 lần, tài khoản của bạn đã bị khóa");
            }else{
                alert()->error("Mã code không tồn tại");
            }
            
        }else{
            // nap vi
            $user_wallet = Wallet::where('user_id',$user->id)->first();
            $wallet_current = 0;
            if($user_wallet)
            {
                $wallet_current = $user_wallet->xu;
                $user_wallet->xu += $code->price;
                $user_wallet->save();
            }
            $dataLog = array(
                'type'=> WalletLog::TYPE_NAP_XU,
                'xu_current'=> $wallet_current,
                'xu_change' => $code->price,
                'note' => 'nạp xu - mã code :'.$data['code'].'- mệnh giá :'.$code->price,
            );
            Helper::walletLog($dataLog, $user);  
            //danh dau code da duoc su dung            
            alert()->success('Nạp mã code thành công');    
        }
        return redirect()->route('user.wallet.add');
    }

    public function history()
    {
        if(!Auth::check())
        {
            return redirect()->route('home');
        }
        $user = Auth::user();
        $limit = 25;
        $var = [];
        $var['histories'] = WalletLog::where('user_id',$user->id)->orderBy('created_at','DESC')->paginate($limit);           
        return view('wallet.history',compact('var'));
    }
}
