
  if(location.pathname == "/") {

    if (navigator.geolocation) {

    // 現在の位置情報を取得
    navigator.geolocation.getCurrentPosition(

      // （1）位置情報の取得に成功した場合
      function (pos) {
        location.href = location.origin +"/location/" + pos.coords.latitude + "/" + pos.coords.longitude;
      },
      // （2）位置情報の取得に失敗した場合
      function (error) {
        var message = "";

        switch (error.code) {

          // 位置情報が取得できない場合
          case error.POSITION_UNAVAILABLE:
          message = "位置情報の取得ができませんでした。";
          break;

          // Geolocationの使用が許可されない場合
          case error.PERMISSION_DENIED:
          message = "位置情報取得の使用許可がされませんでした。";
          break;

          // タイムアウトした場合
          case error.PERMISSION_DENIED_TIMEOUT:
          message = "位置情報取得中にタイムアウトしました。";
          break;
        }
        window.alert(message);
      }
      );
    }
  }
