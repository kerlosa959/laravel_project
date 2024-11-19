@extends('layouts.auth')
@php
    use App\Models\Utility;
    $logo = \App\Models\Utility::get_file('uploads/logo');
    $settings = Utility::settings();
    $company_logo = $settings['company_logo'] ?? '';

@endphp
@push('custom-scripts')
@if ($settings['recaptcha_module'] == 'on')
        {!! NoCaptcha::renderJs() !!}
    @endif
@endpush
@section('page-title')
    {{ __('Login') }}
@endsection

 @section('auth-topbar')
 {{--  <li class="nav-item">
        <select class="btn btn-primary ms-2 me-2 language_option_bg text-center" style="text-align-last: center;" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);" id="language">
            @foreach (Utility::languages() as $code => $language)
                <option class="text-center" @if ($lang == $code) selected @endif value="{{ route('login',$code) }}">{{ucfirst($language)}}</option>
            @endforeach
        </select>
    </li>
    --}}
@endsection 
@php
    $languages = App\Models\Utility::languages();
@endphp

<style>

$mainFont: 'Open Sans', sans-serif;
$mainColor: #333333;

// *{padding: 0px; margin: 0px;}

body {
	background-image: linear-gradient( 135deg, #FAB2FF 10%, #1904E5 100%);
	background-size: cover;
	background-repeat: no-repeat;
	background-attachment: fixed;
	font-family: $mainFont;
	color: $mainColor;
}

.box-form {
	margin: 0 auto;
	width: 80%;	
	background: #FFFFFF;
	border-radius: 10px;
	overflow: hidden;
	
	display: flex;
	flex: 1 1 100%;
  align-items: stretch;
	justify-content: space-between;
	
	box-shadow: 0 0 20px 6px #090b6f85;
	
	
	@media (max-width: 980px) {
		flex-flow:wrap;
		text-align: center;
		align-content: center;
		align-items: center;
	}

	
	div{height: auto;}
	
	.left{
		color: #FFFFFF;
		background-size: cover;
		background-repeat: no-repeat;
		background-image: url("https://i.pinimg.com/736x/5d/73/ea/5d73eaabb25e3805de1f8cdea7df4a42--tumblr-backgrounds-iphone-phone-wallpapers-iphone-wallaper-tumblr.jpg");
		overflow: hidden;

		// overlay
		.overlay {
			padding: 30px;
			width: 100%;
			height: 100%;
			background: #5961f9ad;
			overflow: hidden;
			box-sizing: border-box;
			
			h1{
				font-size: 10vmax;
				line-height: 1;
				font-weight: 900;
				margin-top: 40px;
				margin-bottom: 20px;
			}
			
			span {
				p {margin-top: 30px; font-weight: 900;}
				
				a{
					background: #3b5998;
					color:#FFFFFF;
					margin-top: 10px;
					padding: 14px 50px;
					border-radius: 100px;
					display: inline-block;
					box-shadow: 0 3px 6px 1px #042d4657;
				}
				a:last-child{background: #1dcaff; margin-left: 30px;}
			}
		}
	}
	
	.right {
		padding: 40px;
		overflow: hidden;
						
@media (max-width: 980px) {width: 100%;}

		h5{
			font-size: 6vmax;
			line-height: 0;
			// margin-bottom: 30px;
			

		}
		
		p{font-size: 14px; color: #B0B3B9;}
		
		.inputs{overflow: hidden;}
		
		input{
			width: 100%;
			padding: 10px;
			margin-top: 25px;
			font-size: 16px;
			border: none;
			outline: none;
			border-bottom: 2px solid #B0B3B9;
		}
		
		.remember-me--forget-password {
			display: flex;
			justify-content: space-between;
			align-items: center;
			
			input{
				margin: 0;
				margin-right: 7px;
				width: auto;
			}
		}

		
		
		button {
			float: right;
			color: #fff;
			font-size: 16px;
			padding: 12px 35px;
			border-radius: 50px;
			display: inline-block;
			border: 0; outline: 0;
		  box-shadow: 0px 4px 20px 0px #49c628a6;
			background-image: linear-gradient( 135deg, #70F570 10%, #49C628 100%);
		}
	}
	}





label {

	display: block;
	position: relative;
	margin-left: 30px;
}
label::before{
	content:' \f00c';
	position: absolute;
	font-family: FontAwesome;
	background: transparent;

	border: 3px solid #70F570;
	border-radius: 4px;
	color: transparent;
	left: -30px;
	
	transition: all 0.2s linear;
}

label:hover::before{
	 font-family: FontAwesome;
	content:' \f00c';
	color: #fff;
	cursor: pointer;
	background: #70F570;
}

label:hover::before .text-checkbox{background: #70F570;}
// label span.text-checkbox:hover{background: #70F570;}


label span.text-checkbox {
	display: inline-block;
	height: auto;
	position: relative;
	cursor: pointer;
	transition: all 0.2s linear;
}
label input[type="checkbox"] {display: none;}


</style>
@section('content')
<div class="box-form">
	<div class="left">
		<div class="overlay">
		
	
		</div>
	</div>
	
	
		<div class="right">
		<h5>Login</h5>
		<div class="inputs">
			<input name="email" type="text" placeholder="Email">
			<br>
			<input name="email" type="password" placeholder="Password">
		</div>
			
			<br><br>
			
		<div class="remember-me--forget-password">
				<!-- Angular -->
	<label>
		<input type="checkbox" name="item" checked/>
		<span class="text-checkbox">Remember me</span>
	</label>
			<p>forget password?</p>
		</div>
			
			<br>
			<button>Login</button>
	</div>
	
</div>
@endsection




<script src="{{ asset('js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $("#form_data").submit(function(e) {
            $("#login_button").attr("disabled", true);
            return true;
        });
    });
    
</script>
