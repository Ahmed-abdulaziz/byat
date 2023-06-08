<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Messages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class suggestionController extends Controller
{

    public function index(Request $request)
    {
        abort_if(!auth()->user()->hasPermission('Suggestions'), 403);
        
        $complines = Messages::when($request->search, function ($query) use ($request) {

            return $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');

        })->where('type','=',1)->latest()->paginate(5);

        return view('dashboard.suggestion.index', compact('complines'));

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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
         abort_if(!auth()->user()->hasPermission('Suggestions'), 403);
        // $data=array('body'=>$request->message,'email'=>$request->email,'subject'=>$request->subject,'name'=>$request->name);
        // Mail::send('mail',$data,function ($message) use ($data) {
        //     $message->to($data['email'],$data['name'])->subject($data['subject']);
        // });
        
        $headers = 'From:'. $request->email . "\r\n" .
        "CC: Bayat";
        mail($request->email,$request->subject ,$request->message , $headers );

        $table=DB::table('messages')->where('id','=',$request->id)->update(['status'=>1]);
        return redirect()->route('dashboard.suggestion.index')->with(['success'=>'تم الارسال بنجاح']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Messages  $messages
     * @return \Illuminate\Http\Response
     */
    public function show(Messages $messages)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Messages  $messages
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit($messages)
    {
         abort_if(!auth()->user()->hasPermission('Suggestions'), 403);
         
        $user=Messages::find($messages);
        return view('dashboard.suggestion.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Messages  $messages
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Messages $messages)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Messages  $messages
     * @return \Illuminate\Http\Response
     */
    public function destroy(Messages $messages)
    {
        //
    }
}
