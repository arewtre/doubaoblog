@extends('layouts.home')
@section('content')
  <link href="{{asset('resources/home/tools/css/main.css-v2.9.2.css')}}" type="text/css" rel="stylesheet" />
  <div id="main" style="margin-top:20px;padding:0 40px;">
   <div class="main" style="background-color:#fff;">
    <div class="tools_left fl">
   <div class="title">
    <div class="icon">
     <img src="{{asset('resources/home/tools/images/jsq.png')}}" alt="在线科学计算器" />
    </div>
    <h1>在线科学计算器</h1>
    <div class="zuozhe">
     在线科学计算器
    </div>
   </div>
   <div class="content-a">
    <div id="container">
     <div id="the-calculator">
      <div id="the-display">
       <form name="calculator">
        <span id="total">0</span>
       </form>
      </div>
      <div id="the-buttons">
       <div class="button-row clearfix">
        <button id="calc_clear" value="C/E">C/E</button>
        <button id="calc_back" value="←">←</button>
        <button id="calc_neg" value="-/+">-/+</button>
        <button class="calc_op" value="/">&divide;</button>
       </div>
       <div class="button-row clearfix">
        <button class="calc_int" value="7">7</button>
        <button class="calc_int" value="8">8</button>
        <button class="calc_int" value="9">9</button>
        <button class="calc_op" value="*">&times;</button>
       </div>
       <div class="button-row clearfix">
        <button class="calc_int" value="4">4</button>
        <button class="calc_int" value="5">5</button>
        <button class="calc_int" value="6">6</button>
        <button class="calc_op" value="-">-</button>
       </div>
       <div class="button-row clearfix">
        <button class="calc_int" value="1">1</button>
        <button class="calc_int" value="2">2</button>
        <button class="calc_int" value="3">3</button>
        <button class="calc_op" value="+">+</button>
       </div>
       <div class="button-row clearfix">
        <button id="calc_zero" class="calc_int" value="0">0</button>
        <button id="calc_decimal" value=".">.</button>
        <button id="calc_eval" value="=">=</button>
       </div>
       <div id="extra-buttons" class="button-row">
        <button id="calc_denom" value="1/x"><span class="denominator"><span class="denom-top">1</span><span class="denom-slash">/</span><span class="denom-btm">x</span></span></button>
        <button id="calc_sqrt" value="√">√</button>
        <button id="calc_square" value="x2">x<span class="exponent">2</span></button>
        <button id="calc_powerof" class="calc_op" value="^">y<span class="exponent">x</span></button>
       </div>
      </div>
     </div>
     <div id="the-results">
      <ul id="results_list">
       <li id="result_default">Memory is Empty</li>
      </ul>
      <a id="result_clear" href="#">清除</a>
     </div>
    </div>
    <script src="{{asset('resources/home/tools/js/jsq.js')}}"></script>
   </div>
  </div>
       @include('home/tool/right') 
   </div>
  </div>
<script>
    jQuery("#nv li").removeClass("a");
    jQuery("#mn_tool").addClass("a");

</script>

@endsection