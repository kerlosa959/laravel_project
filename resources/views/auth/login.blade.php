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


@section('content')

@endsection




<script src="{{ asset('js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $("#form_data").submit(function(e) {
            $("#login_button").attr("disabled", true);
            return true;
        });
    });
    const antd = window.antd;

const Login = () => {
  const onFinish = values => {
    console.log('Success:', values);
  };

  const onFinishFailed = errorInfo => {
    console.log('Failed:', errorInfo);
  };

  return (
    <div className="login-page">
      <div className="login-box">
        <div className="illustration-wrapper">
          <img src="https://c8.alamy.com/comp/2BNBY02/businessman-opening-secret-door-opportunity-accessible-entering-risk-solution-and-leadership-business-vector-concept-illustration-of-businessman-open-door-secret-leadership-challenge-opportunity-2BNBY02.jpg" alt="Login"/>
        </div>
        <antd.Form
          name="login-form"
          initialValues={{ remember: true }}
          onFinish={onFinish}
          onFinishFailed={onFinishFailed}
        >
          <p className="form-title">Welcome back</p>
          <p>Login to the Dashboard</p>
          <antd.Form.Item
            name="username"
            rules={[{ required: true, message: 'Please input your username!' }]}
          >
            <antd.Input
              placeholder="Username"
            />
          </antd.Form.Item>

          <antd.Form.Item
            name="password"
            rules={[{ required: true, message: 'Please input your password!' }]}
          >
            <antd.Input.Password 
              placeholder="Password"
            />
          </antd.Form.Item>

          <antd.Form.Item name="remember" valuePropName="checked">
            <antd.Checkbox>Remember me</antd.Checkbox>
          </antd.Form.Item>

          <antd.Form.Item>
            <antd.Button type="primary" htmlType="submit" className="login-form-button">
              LOGIN
            </antd.Button>
          </antd.Form.Item>
        </antd.Form>
      </div>
    </div>
  );
};

ReactDOM.render(
  <Login/>,
  document.getElementById('root')
);
</script>
