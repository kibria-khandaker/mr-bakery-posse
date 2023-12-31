<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller {

    function LoginPage(): View {
        return view( 'pages.auth.login-page' );
    }
    function RegistrationPage(): View {
        return view( 'pages.auth.registration-page' );
    }
    function SendOtpPage(): View {
        return view( 'pages.auth.send-otp-page' );
    }
    function VerifyOTPPage(): View {
        return view( 'pages.auth.verify-otp-page' );
    }
    function ResetPasswordPage(): View {
        return view( 'pages.auth.reset-pass-page' );
    }
    function ProfilePage(): View {
        return view( 'pages.dashboard.profile-page' );
    }

    function UserRegistration( Request $request ) {
        try {
            User::create( [
                'firstName' => $request->input( 'firstName' ),
                'lastName'  => $request->input( 'lastName' ),
                'email'     => $request->input( 'email' ),
                'mobile'    => $request->input( 'mobile' ),
                'password'  => $request->input( 'password' ),
            ] );
            return response()->json( [
                'status'  => 'success',
                'message' => 'User Registration Successful',
            ], 200 );
        } catch ( Exception $e ) {
            return response()->json( [
                'status'  => 'failed',
                // 'message' => 'User Registration Failed', // when production
                'message' => $e->getMessage(), // when development
            ] );
        }

    }

    function UserLogin( Request $request ) {
        $count = User::where( 'email', '=', $request->input( 'email' ) )
            ->where( 'password', '=', $request->input( 'password' ) )
            ->select( 'id' )->first();
        // ->count();

        if ( $count !== null ) {
            $token = JWTToken::CreateToken( $request->input( 'email' ), $count->id );
            return response()->json( [
                'status'  => 'success',
                'message' => 'User Login Successfully',
                // 'token'   => $token, // token show in body for post mane oe view on page for development er jonno
            ], 200 )->cookie( 'token', $token, 60 * 24 * 30 );
        } else {
            return response()->json( [
                'status'  => 'failed',
                'message' => 'unauthorized',
            ], 401 );
        }

    }

    function SendOTPCode( Request $request ) {

        $email = $request->input( 'email' );
        //4 digite er otp generate korbo
        $otp = rand( 1000, 9999 );
        $count = User::where( 'email', '=', $email )->count();
        // dd( $count);
        if ( $count == 1 ) {

            //sent otp to mail
            // Mail::to( $email )->send( new OTPMail( $otp ) );

            //insert otp to database
            User::where( 'email', '=', $email )->update( ['otp' => $otp] );
            // $User = User::where( 'email', '=', $email )->update( ['otp' => $otp] );
            // dd($User);

            return response()->json( [
                'status'  => 'success',
                'message' => '4 Digit OTP sent successfully',
            ], 200 );

        } else {
            return response()->json( [
                'status'  => 'failed',
                'message' => 'unauthorized',
            ], 401 );
        }

    }

    function VerifyOTP( Request $request ) {

        $email = $request->input( 'email' );
        $otp = $request->input( 'otp' );
        $count = User::where( 'email', '=', $email )->where( 'otp', '=', $otp )->count();

        if ( $count == 1 ) {
            // DB OTP Update
            User::where( 'email', '=', $email )->update( ['otp' => '0'] );

            // pass reset token issue
            $token = JWTToken::CreateTokenForSetPassword( $request->input( 'email' ) );
            return response()->json( [
                'status'  => 'success',
                'message' => 'OTP verification Successfully',
                // 'token'   => $token, // token show in body for post mane oe view on page for development er jonno
            ], 200 )->cookie( 'token', $token, 60 * 24 * 30 );
        } else {
            return response()->json( [
                'status'  => 'failed',
                'message' => 'unauthorized',
            ], 401 );
        }

    }

    function ResetPassword( Request $request ) {

        try {
            $email = $request->header( 'email' );
            $password = $request->input( 'password' );
            // return $email;

            // User::where( 'email', '=', $email )->update( ['password' => $password] );
            //     return response()->json( [
            //         'status'  => 'success',
            //         'message' => 'Request Successful'
            //     ], 200 );

            $success = User::where( 'email', '=', $email )->update( ['password' => $password] );
            if ( $success ) {
                return response()->json( [
                    'status'  => 'success',
                    'message' => 'Password Updated Successfully',
                ], 200 )->cookie( 'token', '', -1 );
            } else {
                return response()->json( [
                    'status'  => 'failed',
                    'message' => 'Something went wrong 1',
                ], 401 );
            }

        } catch ( Exception $exception ) {
            return response()->json( [
                'status'  => 'failed',
                'message' => 'Something went wrong 2',
            ], 401 );
        }

    }

    public function UserLogout() {
        // return redirect('/userLogin')->cookie('token', '', -1);
        return redirect( '/' )->cookie( 'token', '', -1 );
    }

    public function UserProfile( Request $request ) {
        $email = $request->header( 'email' );
        $user = User::where( 'email', '=', $email )->first();

        return response()->json( [
            'status'  => 'success',
            'message' => 'Request Successful',
            'data' => $user
        ], 200 );
    }

    function UpdateProfile(Request $request){
        try{
         $email = $request->header('email');
         $firstName = $request->input('firstName');
         $lastName = $request->input('lastName');
         $mobile = $request->input('mobile');
         $password = $request->input('password');
   
         User::where('email','=',$email)->update([
          'firstName'=>$firstName,
          'lastName'=>$lastName,
          'mobile'=>$mobile,
          'password'=>$password
         ]);
         return response()->json([
           'status' => 'success',
           'message' => 'Update successfully'
         ],200);
   
        }catch(Exception $e){
             
         return response()->json([
           'status' => 'failed',
           'message' => 'Something went wrong'
         ],200);
   
        }

    }




}
