@extends('layouts.admin')
@section('content')
<div class="container-fluid">
  <div class="card p-2">
    <h6 class="fs-6 fw-bolder">◆お知らせ情報の管理</h6>
    <p class="fs-7 text-danger">現在ユーザーに表示中のお知らせ（最大３つ）</p>
    <table class="table">
      <tr>
        <th>No.</th>
        <th>タイトル</th>
        <th>お知らせ内容</th>
      </tr>
      <tr>
        <td>1</td>
        <td>{{$info_1->title}}</td>
        <td>{{$info_1->content}}</td>
      </tr>
      <tr>
        <td>2</td>
        <td>{{$info_2->title}}</td>
        <td>{{$info_2->content}}</td>
      </tr>
      <tr>
        <td>3</td>
        <td>{{$info_3->title}}</td>
        <td>{{$info_3->content}}</td>
      </tr>
    </table>

    <p class="fs-7 text-danger">◆変更したい内容</p>
    <table class="table">
      <tr>
        <th>id</th>
        <th>公開NO.</th>
        <th>タイトル</th>
        <th>お知らせ内容</th>
        <th>編集</th>
      </tr>
      @foreach($informations as $information)
      <tr>
        <td>{{ $information->id }}</td>
        <td>{{ $information->status }}</td>
        <td>{{ $information->title }}</td>
        <td>{{ $information->content }}</td>
        <td>
          <button class="edit-button btn btn-primary" data-id="{{ $information->id }}">編集</button>
        </td>
      </tr>
      @endforeach
    </table>
  </div>
</div>

<script>
  // 編集ボタンがクリックされたときの処理
  $(document).on('click', '.edit-button', function() {
        var $informationRow = $(this).closest('tr');
        var informationId = $informationRow.find('td:eq(0)').text();
        var status = $informationRow.find('td:eq(1)').text();
        var title = $informationRow.find('td:eq(2)').text();
        var content = $informationRow.find('td:eq(3)').text();

        var $editForm = $('<tr>' +
          '<td><input class="information_id" disabled type="number" value="' + informationId + '" /></td>' +
          '<td>' +
          '<select class="status-select">' +
          '<option value="1"' + (status === '1' ? ' selected' : '') + '>1</option>' +
          '<option value="2"' + (status === '2' ? ' selected' : '') + '>2</option>' +
          '<option value="3"' + (status === '3' ? ' selected' : '') + '>3</option>' +
          '<option value="公開しない"' + (status === 'nopublic' ? ' selected' : '') + '>公開しない</option>' +
          '</select>' +
          '</td>' +
          '<td><input type="text" class="title-input" value="' + title + '"></td>' +
          '<td><textarea class="content-textarea">' + content + '</textarea></td>' +
          '<td>' +
          '<button class="save-button btn btn-success" data-id="' + informationId + '">保存</button>' +
          '<button class="cancel-button btn btn-secondary">キャンセル</button>' +
          '</td>' +
          '</tr>');

        $informationRow.replaceWith($editForm);

        // 保存ボタンがクリックされたときの処理
        $(document).on('click', '.save-button', function() {
          var informationId = $(this).data('id');
          var $editedForm = $(this).closest('tr');
          var status = $editedForm.find('.status-select').val();
          var title = $editedForm.find('.title-input').val();
          var content = $editedForm.find('.content-textarea').val();

          // ここでAjaxリクエストを送信し、情報を更新する処理を実装する
          // CSRFトークンを取得
          var csrfToken = $('meta[name="csrf-token"]').attr('content');

          $.ajax({
            url: '/admin-limited/informations/update',
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': csrfToken // CSRFトークンをリクエストヘッダーに含める
            },
            data: {
              information_id: informationId,
              status: status,
              title: title,
              content: content
            },
            success: function(response) {
              // 成功時の処理（例: レスポンスのデータに基づいてUIを更新する）
              console.log(response);
            },
            error: function(xhr) {
              // エラー時の処理
              console.log(xhr.responseText);
            }
          });

          var $updatedRow = $('<tr>' +
            '<td>' + informationId + '</td>' +
            '<td>' + status + '</td>' +
            '<td>' + title + '</td>' +
            '<td>' + content + '</td>' +
            '<td>' +
            '<button class="edit-button btn btn-primary" data-id="' + informationId + '">編集</button>' +
            '</td>' +
            '</tr>');

          $editedForm.replaceWith($updatedRow);
        });

        // キャンセルボタンがクリックされたときの処理
        $(document).on('click', '.cancel-button', function() {
            var $editedForm = $(this).closest('tr');
            var informationId = $editedForm.find('.information_id').val();
            var status = $editedForm.find('.status-select option:selected').text();
            var title = $editedForm.find('.title-input').val();
            var content = $editedForm.find('.content-textarea').val();

            var $originalRow = $('<tr>' +
              '<td>' + informationId + '</td>' +
              '<td>' + status + '</td>' +
              '<td>' + title + '</td>' +
              '<td>' + content + '</td>' +
              '<td>' +
              '<button class="edit-button btn btn-primary" data-id="' + informationId + '">編集</button>' +
              '</td>' +
              '</tr>');

            $editedForm.replaceWith($originalRow);
          });
        });

        // 新規登録ボタンがクリックされたときの処理
        $('#new-button').click(function() {
          var $newForm = $('<tr>' +
            '<td>' +
            '<select class="status-select">' +
            '<option value="1">1</option>' +
            '<option value="2">2</option>' +
            '<option value="3">3</option>' +
            '<option value="nopublic">公開しない</option>' +
            '</select>' +
            '</td>' +
            '<td><input type="text" class="title-input"></td>' +
            '<td><textarea class="content-textarea"></textarea></td>' +
            '<td>' +
            '<button class="save-button">保存</button>' +
            '<button class="cancel-button">キャンセル</button>' +
            '</td>' +
            '</tr>');

          $(this).before($newForm);

          // 保存ボタンがクリックされたときの処理
          $('.save-button').click(function() {
            var $newForm = $(this).closest('tr');
            var status = $newForm.find('.status-select').val();
            var title = $newForm.find('.title-input').val();
            var content = $newForm.find('.content-textarea').val();

            // ここでAjaxリクエストを送信し、新規レコードを追加する処理を実装する

            var $newRow = $('<tr>' +
              '<td>' + status + '</td>' +
              '<td>' + title + '</td>' +
              '<td>' + content + '</td>' +
              '<td>' +
              '<button class="edit-button btn btn-primary" data-id="NEW">編集</button>' +
              '</td>' +
              '</tr>');

            $newForm.replaceWith($newRow);
          });

          // キャンセルボタンがクリックされたときの処理
          $('.cancel-button').click(function() {
            $(this).closest('tr').remove();
          });
        });
</script>
@endsection