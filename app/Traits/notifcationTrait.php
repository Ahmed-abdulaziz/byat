<?php
namespace App\Traits;
trait notifcationTrait
{
  public function broadCastNotification($title, $body , $topic )
  {
    // $topic = "laytwfkApp";
    $auth_key = "AAAASAI_Ak8:APA91bEkQ0Ll5khI0VpZ8ATOouZuYF1eykpIHXwADRQJhfyKoITVY2IihjAoy5TotYHYCv0LXT5FlnV2AIu-gJPPuzZIbWaS6AmUfEGcOKSnJwR7qpgn0bAoi7pLIioWunNOF6a2qea0";
    $topic = "/topics/$topic";
    $data = [
      'title' => $title,
      'body' => $body,
      'icon' => 'https://drive.google.com/file/d/1yLZw2bYmDoH8SsAOp0KJFhh0l9EO9JwZ/view',
      'banner' => '0',
      'sound' => 'default',
      "priority" => "high",
    ];
    $notification = [
      'title' => $title,
      'body' => $body,
      'sound' => 'default',
      'icon' => 'https://drive.google.com/file/d/1yLZw2bYmDoH8SsAOp0KJFhh0l9EO9JwZ/view',
      'banner' => '0',
      "priority" => "high",
      'data' => $data
    ];
    $fields = json_encode([
      'to' => $topic,
      'notification' => $notification,
      'data' => $data
    ]);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: key=' . $auth_key, 'Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    $result = curl_exec($ch);
    curl_close($ch);
  }
  public function pushNotification($notification)
  {
      $auth_key ="AAAASAI_Ak8:APA91bEkQ0Ll5khI0VpZ8ATOouZuYF1eykpIHXwADRQJhfyKoITVY2IihjAoy5TotYHYCv0LXT5FlnV2AIu-gJPPuzZIbWaS6AmUfEGcOKSnJwR7qpgn0bAoi7pLIioWunNOF6a2qea0";
    $device_token = $notification['device_token'];
    $data = [
      'body' => $notification['body'],
      'title' => $notification['title'],
      'id' => $notification['id'],
      'type' => $notification['type'],
// 'badge' => $notification['badge'],
      'click_action' => $notification['click_action'],
      'icon' => asset('backend/appIcon.png'),
      'banner' => '0',
      'sound' => 'default',
      "priority" => "high"
    ];
    $notification = [
      'body' => $notification['body'],
      'title' => $notification['title'],
      'id' => $notification['id'],
      'type' => $notification['type'],
// 'badge' => $notification['badge'],
      'click_action' => $notification['click_action'],
      'data' => $data,
      'icon' => asset('backend/appIcon.png'),
      'banner' => '0',
      'sound' => 'default',
      "priority" => "high"
    ];
    $fields = json_encode([
      'registration_ids' => $device_token,
      'notification' => $notification,
      'data' => $data,
    ]);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: key=' . $auth_key, 'Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    $result = curl_exec($ch);
    if ($result === FALSE) {
      die('FCM Send Error: ' . curl_error($ch));
    }
    curl_close($ch);
  }
}
