<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    /**
     * Gửi email chào mừng cho user mới
     * 
     * @param int $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendWelcomeEmail($userId)
    {
        try {
            // Tìm user theo ID, nếu không tìm thấy sẽ throw exception
            $user = User::findOrFail($userId);
            
            // Gửi email sử dụng WelcomeMail class
            Mail::to($user->email)->send(new WelcomeMail($user));
            
            // Trả về JSON response thành công
            return response()->json([
                'success' => true,
                'message' => 'Email đã được gửi thành công đến ' . $user->email
            ]);
            
        } catch (\Exception $e) {
            // Xử lý lỗi và trả về JSON response lỗi
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi gửi email: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Gửi email test từ form
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendTestEmail(Request $request)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string|max:255'
        ]);
        
        try {
            // Tạo một user object tạm thời (không lưu vào database)
            $testUser = new User();
            $testUser->name = $request->name;
            $testUser->email = $request->email;
            $testUser->created_at = now();
            
            // Gửi email
            Mail::to($request->email)->send(new WelcomeMail($testUser));
            
            // Redirect về trang trước với thông báo thành công
            return back()->with('success', 'Email test đã được gửi thành công đến ' . $request->email);
            
        } catch (\Exception $e) {
            // Redirect về trang trước với thông báo lỗi
            return back()->with('error', 'Lỗi khi gửi email: ' . $e->getMessage());
        }
    }
    
    /**
     * Hiển thị form test email
     * 
     * @return \Illuminate\View\View
     */
    public function showTestForm()
    {
        return view('emails.test-form');
    }
}