'use strict';


//チェックボックスにチェックを入れるだけではデータ送信されないのでJSでsubmit処理をする
//送信先：formタグのアクション属性を確認する
{
    const checkboxs = document.querySelectorAll('input[type="checkbox"]');
    checkboxs.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            //親タグに設定しているformタグが送信処理をする
            checkbox.parentNode.submit();
        })
    });
}

//×をクリックしただけではデータ送信されないのでJSでsubmit処理をする
//送信先：formタグのアクション属性を確認する
{
    const deletes = document.querySelectorAll('.delete');
    deletes.forEach(span => {
        span.addEventListener('click', () => {
            //確認をキャンセルしたら何もしない
            if (!confirm('Are you sure')) {
                return;
            }
            //親タグに設定しているformタグが送信処理をする
            span.parentNode.submit();
        })
    });
}


//purgeをクリックしただけではデータ送信されないのでJSでsubmit処理をする
//送信先：formタグのアクション属性を確認する
{
    const purge = document.querySelector('.purge');
    purge.addEventListener('click', () => {
        //確認をキャンセルしたら何もしない
        if (!confirm('Are you sure')) {
            return;
        }
        //親タグに設定しているformタグが送信処理をする
        purge.parentNode.submit();
    });
}