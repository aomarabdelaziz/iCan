<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Center;
use App\Models\Evaluation;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CenterEvaluationController extends Controller
{
    use ApiResponser;
    public function __invoke(Request $request)
    {
        $validator =  Validator::make($request->all(),[
            'rate' => ['required','int','max:5'],
            'center_id' => ['required' , Rule::exists('centers' , 'id')],
        ]);

        if($validator->fails()){
            return $this->error('Validation Error' , 401 ,$validator->errors());
        }

        Evaluation::evaluateCenter($validator->validated());

        $this->placeRating($validator->validated());

        return $this->success("Center rating has been submitted");
    }

    public function placeRating($validated)
    {
        $id = $validated['center_id'];
        $ratings = Evaluation::where('center_id',$id)->get();
        $ratingValues = [];

        foreach ($ratings as $aRating) {
            $ratingValues[] = $aRating->rate;
        }

        $ratingAverage = collect($ratingValues)->sum() / $ratings->count();

        Center::find($id)->update(['rating' => $ratingAverage]);
        //return $ratingAverage;
    }

}
