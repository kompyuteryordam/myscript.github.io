<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Redirect;
use Response;
use Carbon\Carbon;

use App\Cards;
use App\Items;
use App\Games;
use App\User;
use App\Settings;
use App\Reviews;

class IndexController extends Controller
{
	const currency = 643; // pay-trio
	public function index(Request $r)
	{
		$cases = Cards::get();
		foreach($cases as $c)
		{
			$max = Items::where('card', $c->id)->orderBy('cost', 'desc')->first();
			$min = Items::where('card', $c->id)->orderBy('cost', 'asc')->first();
			$c->max = $max->cost;
			$c->min = $min->cost;
		}
		
		$top_users = User::orderBy('profit', 'desc')->limit(10)->get();
		
		
		if(isset($r->utm_term))
		{
			$utm = User::where('id', $r->utm_term)->first();
			if($utm == true)
			{
				$utm_name = $utm->username;
				$utm_avatar = $utm->avatar;
				return view('pages.index', compact('cases', 'top_users', 'utm_name', 'utm_avatar'));
			}
			else
			{
				return view('pages.index', compact('cases', 'top_users'));
			}
		}
		else
		{
			return view('pages.index', compact('cases', 'top_users'));
		}
	}
    public function cart($id)
	{
		$card = Cards::where('id', $id)->first();
		if($card == false)
		{
			return abort(404);
		}
		
		$items = Items::where('card', $id)->orderBy('cost', 'desc')->get();
		return view('pages.cart', compact('card', 'items'));
	}
	public function open(Request $r)
	{
		if(!isset($r->id) || !isset($r->game_id) || !isset($r->number))
		{
			return 'err';
		}
		
		if(Auth::guest())
		{
			return json_encode(["status" => 403]);
		}
		
		$card = Cards::where('id', $r->id)->first();
		if($card == false)
		{
			return Response::json(['error' => 'Error #405.1'],405);
		}
		
		
		if(Auth::user()->deposit == 0 && Auth::user()->money == 0)
		{
			if(Auth::user()->bonus_money < $card->cost)
			{
				return json_encode(["status" => 401]);
			}
			$chance = $card->chance+44;
		}
		else
		{
			if(Auth::user()->money < $card->cost)
			{
				return json_encode(["status" => 401]);
			}
			if(Auth::user()->is_yt == 1)
			{
				$chance = 80;
			}
			else
			{
				$chance = $card->chance;
			}
		}
		
		$general_game = $r->game_id;
		
		
		
		
		
		$is_last = false;
		if($general_game != false && $general_game != "false")
		{
			$next_cost = $card->cost*1.4;
			$price = $card->cost*1.2;
			$game = Games::where('id', $general_game)->first();
			$count = Games::where('general_game', $game->general_game)->count();
			if($count == 1)
			{
				$price = $card->cost*1.4;
				$is_last = true;
			}
		}
		else
		{
			$next_cost = $card->cost*1.2;
			$price = $card->cost;
		}
		$user = Auth::user();
		
		if(Auth::user()->deposit == 0 && Auth::user()->money == 0)
		{
			$user->bonus_money = $user->bonus_money-$price;
		}
		else
		{
			$user->money = $user->money - $price;
		}
		
		$user->save();
		
		
		$pro = mt_rand(1,100);
		
		if($pro < $chance)
		{
			$item = Items::where('card', $card->id)->where('cost', '>=', $card->cost)->where('cost', '<=', $card->cost*4)->where('type', 0)->orderByRaw("RAND()")->first();
			if(empty($item))
			{
				$item = Items::where('card', $r->id)->orderByRaw("RAND()")->first();
			}
		}
		elseif($pro >= $chance)
		{
			$item = Items::where('card', $card->id)->where('cost', '<', $card->cost)->where('type', 0)->orderByRaw("RAND()")->first();
			if(empty($item))
			{
				$item = Items::where('card', $r->id)->orderByRaw("RAND()")->first();
			}
		}
		$game = Games::where('id', $general_game)->first();
		if(!empty($game) && $game->general_game != 0)
		{
			$general_game = $game->general_game;
		}
		$game_id = \DB::table('games')->insertGetId(['user' => Auth::user()->id, 'drop_item' => $item->id, 'general_game' => $general_game, 'card' => $item->card]);
		$user = Auth::user();
		
		if(Auth::user()->deposit == 0 && Auth::user()->money == 0)
		{
			$user->bonus_money = $user->bonus_money+ $item->cost;
			$user->profit = $user->profit+$card->cost;
			$user->opened = $user->opened + 1;
			
			$u_money = $user->bonus_money;
		}
		else
		{
			$user->money = $user->money + $item->cost;
			$user->profit = $user->profit+$card->cost;
			$user->opened = $user->opened + 1;
			$u_money = $user->money;
		}
		
		$user->save();
		if($is_last == true)
		{
			$next_cost = $card->cost;
			$general_game = 0;
		}
		return json_encode(["status" => 200, "result" => ["winner_image" => $item->image, "winner_light" => "none", "game_id" => $game_id, "game_price" => $next_cost, "games" => [], "usedEggs" => [], "is_last_game" => $is_last, "balance" => $u_money, "labelNext" => "Продолжить за ".$next_cost."<span class='rouble'>p</span>"]]);
		
		
		
		
		//return '{"status":200,"result":{"winner_image":"\/img\/coins\/150\/70.png","winner_light":"none","game_id":5099848,"game_price":120,"games":[],"usedEggs":[],"is_last_game":false,"balance":1430,"labelNext":"\u041f\u0440\u043e\u0434\u043e\u043b\u0436\u0438\u0442\u044c \u0437\u0430 120<span class=\"rouble\">p<\/span>"}}';
		// {"status":200,"result":{"winner_image":"\/img\/coins\/150\/30.png","winner_light":"none","game_id":5252678,"game_price":24,"games":[],"usedEggs":[],"is_last_game":false,"balance":1940,"labelNext":"\u041f\u0440\u043e\u0434\u043e\u043b\u0436\u0438\u0442\u044c \u0437\u0430 24<span class=\"rouble\">p<\/span>"}} -- ПЕРВАЯ ПОПЫТКА
		// {"status":200,"result":{"winner_image":"\/img\/coins\/150\/15.png","winner_light":"none","game_id":5252762,"game_price":28,"games":[5252678],"usedEggs":[234],"is_last_game":false,"balance":1931,"labelNext":"\u041f\u0440\u043e\u0434\u043e\u043b\u0436\u0438\u0442\u044c \u0437\u0430 28<span class=\"rouble\">p<\/span>"}} -- ПРОДОЛЖИТЬ 24 РУБЛЯ
		// {"status":200,"result":{"winner_image":"\/img\/coins\/150\/150.png","winner_light":"none","game_id":5252862,"game_price":32,"games":[5252762,5252678],"usedEggs":[232,234],"is_last_game":true,"balance":2053,"labelNext":"\u041f\u0440\u043e\u0434\u043e\u043b\u0436\u0438\u0442\u044c \u0437\u0430 32<span class=\"rouble\">p<\/span>"}} - ПРОДОЛЖИТЬ 28 РУБЛЕЙ
		// {"status":200,"result":[{"image":"\/img\/coins\/150\/40.png","light":"none"},{"image":"\/img\/coins\/150\/7.png","light":"none"},{"image":"\/img\/coins\/150\/20.png","light":"none"},{"image":"\/img\/coins\/150\/50.png","light":"none"},{"image":"\/img\/coins\/150\/70.png","light":"none"},{"image":"\/img\/coins\/150\/5.png","light":"none"},{"image":"\/img\/coins\/150\/250.png","light":"none"},{"image":"\/img\/coins\/150\/100.png","light":"none"},{"image":"\/img\/coins\/150\/10.png","light":"none"}]} = НАЧАть зАНОВО
		
		
		
		// {"status":200,"result":{"winner_image":"\/img\/coins\/150\/7.png","winner_light":"none","game_id":5256247,"game_price":12,"games":[],"usedEggs":[],"is_last_game":false,"balance":2080,"labelNext":"\u041f\u0440\u043e\u0434\u043e\u043b\u0436\u0438\u0442\u044c \u0437\u0430 12<span class=\"rouble\">p<\/span>"}} - 10r
		// {"status":200,"result":{"winner_image":"\/img\/coins\/150\/30.png","winner_light":"none","game_id":5256330,"game_price":14,"games":[5256247],"usedEggs":[220],"is_last_game":false,"balance":2098,"labelNext":"\u041f\u0440\u043e\u0434\u043e\u043b\u0436\u0438\u0442\u044c \u0437\u0430 14<span class=\"rouble\">p<\/span>"}} - Продолжить 12р -> 14р
		// {"status":200,"result":[{"image":"\/img\/coins\/150\/3.png","light":"none"},{"image":"\/img\/coins\/150\/20.png","light":"none"},{"image":"\/img\/coins\/150\/1.png","light":"none"},{"image":"\/img\/coins\/150\/100.png","light":"none"},{"image":"\/img\/coins\/150\/10.png","light":"none"},{"image":"\/img\/coins\/150\/70.png","light":"none"},{"image":"\/img\/coins\/150\/40.png","light":"none"},{"image":"\/img\/coins\/150\/15.png","light":"none"},{"image":"\/img\/coins\/150\/50.png","light":"none"},{"image":"\/img\/coins\/150\/5.png","light":"none"}]} - начать заново
		
	}
	public function tokta(Request $r)
	{
		$game = Games::where('id', $r->game_id)->first();
		if($game->general_game == 0)
		{
			$count = 11;
		}
		else
		{
			$c = Games::where('general_game', $game->general_game)->count();
			$count = 11 - $c;
		}
		
		$i = 0;
		$result = [];
		$card = Cards::where('id', $game->card)->first();
		while($i < $count)
		{
			$item = Items::where('card', $game->card)->where('cost', '>', $card->cost)->orderByRaw("RAND()")->first();
			$array2 = ["image" => $item->image, "light" => "none"];
			array_push($result, $array2);
			$i++;
		}
		
		return json_encode(["status" => 200, "result" => $result]);
	}
	
	public function help()
	{
		return view('pages.help');
	}
	
	public function profile()
	{
		if(Auth::guest())
		{
			return redirect('/');
		}
		$usr_pos = User::where('profit', '>', Auth::user()->profit)->count()+1;
		$history = Games::where('user', Auth::user()->id)->limit(24)->orderBy('id', 'desc')->get();
		$last_g = 0;
		foreach($history as $h)
		{
			$card = Cards::where('id', $h->card)->first();
			if(!empty($card))
			{
				$h->name = $card->name;
				$item = Items::where('id', $h->drop_item)->first();
				if($item == true)
				{
					$h->image = $item->image;
				}
			}
			$last_g = $h->id;
		}
		return view('pages.profile', compact('usr_pos', 'history', 'last_g'));
	}
	public function profile_partner()
	{
		if(Auth::guest())
		{
			return redirect('/');
		}
		$usr_pos = User::where('profit', '>', Auth::user()->profit)->count()+1;
		$referals = User::where('ref_use', Auth::user()->id)->orderBy('id', 'desc')->get();
		return view('pages.partner', compact('usr_pos', 'history', 'usr_pos', 'referals'));
	}
	
	public function link()
	{
		if(Auth::guest())
		{
			return redirect()->back();
		}
		else
		{
			if(Auth::user()->ref_link != 'none')
			{
				return redirect()->back();
			}
			$settings = Settings::where('id', 1)->first();
			$link = 'http%3A%2F%2F'.$_SERVER['HTTP_HOST'].'%2F%3Futm_source%3Dfriend%26utm_medium%3Dlink%26utm_term%3D'.Auth::user()->id.'%26utm_campaign%3Daffiliate';
			$homepage = json_decode(file_get_contents('https://api.vk.com/method/utils.getShortLink?url='.$link.'&access_token='.$settings->vk_token));
			$user = Auth::user();
			$user->ref_link = $homepage->response->short_url;
			$user->save();
			return redirect()->back();
		}
	}
	
	public function profile_finance()
	{
		if(Auth::guest())
		{
			return redirect()->back();
		}
		
		
		$operations = \DB::table('operations')->where('user', Auth::user()->id)->orderBy('id', 'desc')->limit(100)->get();
		$usr_pos = User::where('profit', '>', Auth::user()->profit)->count()+1;
		return view('pages.finance', compact('usr_pos', 'operations', 'o'));
	}
	
	public function bonus()
	{
		return view('pages.bonus');
	}
	
	public function payment(Request $r)
	{
		if($r->currency == '')
		{
			return Response::json([
				'message' => 'The given data was invalid.',
				'errors' => ['currency' => ['Необходимо выбрать платежную систему!'], 'provider' => ['Поле необходио для заполнения']]
			], 422);
		}
		else
		{
			$settings = Settings::where('id', 1)->first();
			if($r->amount < $settings->min_dep)
			{
				return Response::json([
					'message' => 'The given data was invalid.',
					'errors' => ['amount' => ['Минимальная сумма пополнения: '.$settings->min_dep.' рублей!']]
				], 422);
			}
			$amount = $r->amount; 
			$type = $r->currency; 
			if((int)$amount < 1){
				$amount = 99;
			}
			$int_id =  \DB::table('operations')->insertGetId([
				'amount' => (int)$amount, 
				'user' => Auth::user()->id, 
				'type' => 0, // ТИП - ПОПОЛНЕНИЕ
				'status' => 0,
				'ref_user' => Auth::user()->ref_use,
				'timestamp' => Carbon::now()
			]);
			$orderID = $int_id;
			$settings = Settings::where('id', 1)->first();
			if($settings->payment_type == 0) // Если стоит тип оплаты по фрикассе
			{
				$sign = md5($settings->fk_id.':'.$amount.':'.$settings->fk_secret1.':'.$orderID);
				if($type == 1) { $type = 94; } // VISA
				elseif($type == 5) { $type = 45; } // yM
				elseif($type == 4) { $type = 155; } // QIWI
				elseif($type == 10) { $type = 114; } // PAYEER
				elseif($type == 19) { $type = 84; } // MTS
				elseif($type == 18) { $type = 82; } // MEGAFON
				elseif($type == 21) { $type = 83; } // BEELINE
				elseif($type == 20) { $type = 132; } // TELE2
				
				$url = 'http://www.free-kassa.ru/merchant/cash.php?m='.$settings->fk_id.'&oa='.$amount.'&o='.$orderID.'&s='.$sign.'&lang=ru&i='.$type;
				return json_encode(['url' => $url]);
			}
			elseif($settings->payment_type == 1)
			{
				$currency = self::currency;
				$shop_id = $settings->pt_shopid;
				$secret = $settings->pt_secret;
				
				
				$request = array("amount" => $amount, "currency" => $currency, "shop_id" => $shop_id, "shop_invoice_id" => $orderID);
				ksort($request);
				$vals = array_values($request);
				$joined = join(":", $vals);
				$sign = md5($joined.$secret);
				
				$TIP_URL = 'https://tip.pay-trio.com/ru';
				$request["sign"] = $sign;
				$get_url = $TIP_URL."?".http_build_query($request);
				$response = array("url" => $get_url);
				return json_encode($response);
			}
		}
	}
	public function get_games(Request $r)
	{
		$games = Games::where('id', '<', $r->last_game_id)->where('user', $r->user_id)->orderBy('id', 'desc')->limit(24)->get();
		$content = '';
		$last = '';
		if($games == false)
		{
			return json_encode(["status" => 200, "result" => ["content" => $content, 'count' => count($games)]]);
		}
		$count = count($games);
		foreach($games as $key => $g)
		{
			$last = $g->id;
			$card = Cards::where('id', $g->card)->first();
			$item = Items::where('id', $g->drop_item)->first();
			$content = $content.'<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
									<div class="game__contains-cell game__contains-cell_none">
										
											<div class="game__contains-img-wrapper game__contains-img-wrapper_with-header">
												<div class="game__contains-header">'.$card->name.'</div>
												<div class="game__contains-egg-glow"></div><img src="'.$item->image.'" alt="" class="game__contains-egg-img">
											</div>
										
									</div>
								</div> ';
		}
		return json_encode(["status" => 200, "result" => ["content" => $content, 'count' => count($games), 'last_id' => $last]]);
	}
	
	public function getpayment(Request $r)
	{
		$settings = Settings::where('id', 1)->first();
		
		if(isset($r->MERCHANT_ORDER_ID))
		{
		
			$sign = md5($settings->fk_id.':'.$r->AMOUNT.':'.$settings->fk_secret2.':'.$r->MERCHANT_ORDER_ID);
			$payment = \DB::table('operations')->where('id', $r->MERCHANT_ORDER_ID)->first();
			if(count($payment) == 0)
			{
				return "err[#1]";
			}
			else
			{
				if($payment->status != 0)
				{
					return "err[#2]";
				}
				else
				{
					if($payment->amount != $r->AMOUNT)
					{
						return "err[#3]";
					}
					else
					{
						if($payment->type != 0)
						{
							return "err[#4]";
						}
						$user = User::where('id', $payment->user)->first();
						$user->money = $user->money + $payment->amount;
						$user->deposit = $user->deposit + $payment->amount;
						$user->save();
						$te = User::where('id', $user->ref_use)->first();
						if(count($te) == null || count($te) == 0)
						{

						}
						else
						{
							$bon = ($settings->ref_percent/100)*$payment->amount;
							$te->money =   $te->money + $bon;
							$te->save();
							$int_id =  \DB::table('operations')->insertGetId([
								'amount' => $bon, 
								'user' => $te->id, 
								'type' => 3, // ТИП - Партнер
								'status' => 1,
								'timestamp' => Carbon::now()
							]);
						}
						\DB::table('operations')
						->where('id', $payment->id)
						->update(['status' => 1]);
						return 'success';
					}
				}
			}
		}
		elseif(isset($r->shop_invoice_id))
		{
			$payment=   \DB::table('operations')->where('id', $r->shop_invoice_id)->first();
			if(count($payment) == 0)
			{
				return "err#1";
			}
			else
			{
				if($payment->status != 0){
					return "err#2";
				}
				else
				{
					if($payment->amount != $r->client_price)
					{
						return "err#3";
					}
					else
					{
						if($payment->type != 0)
						{
							return "err#4";
						}
						$user = User::where('id', $payment->user)->first();
						$user->money = $user->money + $payment->amount;
						$user->save();
						
						$te = User::where('id', $user->ref_use)->first();
						if(count($te) == null || count($te) == 0)
						{

						}
						else
						{
							$bon = ($settings->ref_percent/100)*$payment->amount;
							$int_id =  \DB::table('operations')->insertGetId([
								'amount' => $bon, 
								'user' => $te->id, 
								'type' => 3, // ТИП - Партнер
								'status' => 1,
								'timestamp' => Carbon::now()
							]);
							$te->money =   $te->money + $bon;
							$te->save();
						}

						\DB::table('payments')->where('id', $payment->id)->update(['status' => 1]);
						return 'OK';
					}
				}
			}
		}
	}
	public function pavailable()
	{
		if(!Auth::guest())
		{
			return '{"status":200,"amount":'.Auth::user()->money.',"purses":{"qiwi":null,"yandex":null,"payeer":null}}';
		}
	}
	public function payeer(Request $r)
	{
		if(!Auth::guest())
		{
			if($r->amount == '')
			{
				return Response::json([
					'message' => 'The given data was invalid.',
					'errors' => ['amount' => ['Введите сумму!']]
				], 422);
			}
			if($r->purse == '')
			{
				return Response::json([
					'message' => 'The given data was invalid.',
					'errors' => ['purse' => ['Выберите систему для вывода!']]
				], 422);
			}
			
			$settings = Settings::where('id', 1)->first();
			
			if((int)$r->amount < (int)$settings->min_width)
			{
				return Response::json([
					'message' => 'The given data was invalid.',
					'errors' => ['amount' => ['Минимальная сумма вывода: '.$settings->min_width.'!']]
				], 422);
			}
			
			if(Auth::user()->money < $r->amount)
			{
				return Response::json([
					'message' => 'The given data was invalid.',
					'errors' => ['amount' => ['На балансе недостаточно средств!']]
				], 422);
			}
			
			$ops = \DB::table('operations')->where('user', Auth::user()->id)->where('type', 1)->where('status', 0)->count();
			
			if($ops >= 1)
			{
				return Response::json([
					'message' => 'The given data was invalid.',
					'errors' => ['amount' => ['Дождитесь предыдущего вывода!']]
				], 422);
			}
			
			$user = Auth::user();
			$user->money = $user->money - $r->amount;
			$user->save();
			$int_id =  \DB::table('operations')->insertGetId([
				'amount' => (int)$r->amount, 
				'user' => Auth::user()->id, 
				'type' => 1, // ТИП - ВЫВОД
				'status' => 0,
				'koshelek' => 'payeer',
				'nomer' => $r->purse,
				'timestamp' => Carbon::now()
			]);
			
			return json_encode(["status" => 200, "balance" => $user->money]);
		}
	}
	public function qiwi(Request $r)
	{
		if(!Auth::guest())
		{
			if($r->amount == '')
			{
				return Response::json([
					'message' => 'The given data was invalid.',
					'errors' => ['amount' => ['Введите сумму!']]
				], 422);
			}
			if($r->purse == '')
			{
				return Response::json([
					'message' => 'The given data was invalid.',
					'errors' => ['purse' => ['Выберите систему для вывода!']]
				], 422);
			}
			
			$settings = Settings::where('id', 1)->first();
			
			if((int)$r->amount < (int)$settings->min_width)
			{
				return Response::json([
					'message' => 'The given data was invalid.',
					'errors' => ['amount' => ['Минимальная сумма вывода: '.$settings->min_width.'!']]
				], 422);
			}
			
			if(Auth::user()->money < $r->amount)
			{
				return Response::json([
					'message' => 'The given data was invalid.',
					'errors' => ['amount' => ['На балансе недостаточно средств!']]
				], 422);
			}
			
			$ops = \DB::table('operations')->where('user', Auth::user()->id)->where('type', 1)->where('status', 0)->count();
			
			if($ops >= 1)
			{
				return Response::json([
					'message' => 'The given data was invalid.',
					'errors' => ['amount' => ['Дождитесь предыдущего вывода!']]
				], 422);
			}
			
			$user = Auth::user();
			$user->money = $user->money - $r->amount;
			$user->save();
			$int_id =  \DB::table('operations')->insertGetId([
				'amount' => (int)$r->amount, 
				'user' => Auth::user()->id, 
				'type' => 1, // ТИП - ВЫВОД
				'status' => 0,
				'koshelek' => 'qiwi',
				'nomer' => $r->purse,
				'timestamp' => Carbon::now()
			]);
			
			return json_encode(["status" => 200, "balance" => $user->money]);
		}
	}
	public function yandex(Request $r)
	{
		if(!Auth::guest())
		{
			if($r->amount == '')
			{
				return Response::json([
					'message' => 'The given data was invalid.',
					'errors' => ['amount' => ['Введите сумму!']]
				], 422);
			}
			if($r->purse == '')
			{
				return Response::json([
					'message' => 'The given data was invalid.',
					'errors' => ['purse' => ['Выберите систему для вывода!']]
				], 422);
			}
			
			$settings = Settings::where('id', 1)->first();
			
			if((int)$r->amount < (int)$settings->min_width)
			{
				return Response::json([
					'message' => 'The given data was invalid.',
					'errors' => ['amount' => ['Минимальная сумма вывода: '.$settings->min_width.'!']]
				], 422);
			}
			
			if(Auth::user()->money < $r->amount)
			{
				return Response::json([
					'message' => 'The given data was invalid.',
					'errors' => ['amount' => ['На балансе недостаточно средств!']]
				], 422);
			}
			
			$ops = \DB::table('operations')->where('user', Auth::user()->id)->where('type', 1)->where('status', 0)->count();
			
			if($ops >= 1)
			{
				return Response::json([
					'message' => 'The given data was invalid.',
					'errors' => ['amount' => ['Дождитесь предыдущего вывода!']]
				], 422);
			}
			
			$user = Auth::user();
			$user->money = $user->money - $r->amount;
			$user->save();
			$int_id =  \DB::table('operations')->insertGetId([
				'amount' => (int)$r->amount, 
				'user' => Auth::user()->id, 
				'type' => 1, // ТИП - ВЫВОД
				'status' => 0,
				'koshelek' => 'yandex',
				'nomer' => $r->purse,
				'timestamp' => Carbon::now()
			]);
			
			return json_encode(["status" => 200, "balance" => $user->money]);
		}
	}
	public function lastOpen(Request $r)
	{
		$game = Games::where('id', $r->id)->first();
		$item = Items::where('id', $game->drop_item)->first();
		$user = User::where('id', $game->user)->first();
		
		$total = Games::count();
		
		return json_encode(['boxId' => $game->card, "image" => "/img/coins/90/".$item->cost.".png", "light" => "none", "link" => "/user/".$game->user, "photo" => $user->avatar, "total" => $total, "totalBox" => 18, "userId" => $user->id]);
	}
	public function u_count()
	{
		$count = User::count();
		return json_encode(["count" => $count]);
	}
	
	public function terms()
	{
		return view('pages.terms');
	}
	public function privacy()
	{
		return view('pages.privacy');
	}
	
	public function user($id)
	{
		$user = User::where('id', $id)->first();
		if($user == false)
		{
			abort(404);
		}
		if(!Auth::guest() && Auth::user()->id == $id)
		{
			return redirect('/profile');
		}
		
		$usr_pos = User::where('profit', '>',$user->profit)->count()+1;
		$history = Games::where('user', $user->id)->limit(24)->orderBy('id', 'desc')->get();
		$last_g = 0;
		foreach($history as $h)
		{
			$card = Cards::where('id', $h->card)->first();
			if(!empty($card))
			{
				$h->name = $card->name;
				$item = Items::where('id', $h->drop_item)->first();
				if($item == true)
				{
					$h->image = $item->image;
				}
			}
			$last_g = $h->id;
		}
		return view('pages.user', compact('user', 'usr_pos', 'history', 'last_g'));
	}
	
	public function top100()
	{
		$top10 = User::orderBy('profit', 'desc')->limit(10)->get();
		
		$top90 = User::orderBy('profit', 'desc')->skip(10)->limit(90)->get();
		return view('pages.top', compact('top10', 'top90'));
	}
	public function opinions()
	{
		$reviews = Reviews::orderBy('id', 'desc')->get();
		return view('pages.opinions', compact('reviews'));
	}
	
	public function success()
	{
		return redirect('/');
	}
}
