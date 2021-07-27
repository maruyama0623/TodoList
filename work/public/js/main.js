'use strict';


//チェックボックスにチェックを入れるだけではデータ送信されないのでJSでsubmit処理をする
//送信先：formタグのアクション属性を確認する
{
    const checkboxs = document.querySelectorAll('input[type="checkbox"]');
    checkboxs.forEach(checkbox => {
        checkbox.addEventListener('change', () => {

            //親タグに設定しているformタグが送信処理をする→ただsubmitだとページ遷移が起きる難点が…
            // checkbox.parentNode.submit();

            //fetch(url,options)でページ遷移せずにデータを送信できる
            fetch('?ation=toggle', {
                method: 'POST',
                body: new URLSearchParams({
                    id: checkbox.dataset.id,
                    token: checkbox.dataset.token,
                }),
            });
        });
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
            // span.parentNode.submit();

            fetch('?ation=delete', {
                method: 'POST',
                body: new URLSearchParams({
                    id: span.dataset.id,
                    token: span.dataset.token,
                }),
            });

            span.parentNode.remove();
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

        fetch('?ation=purge', {
            method: 'POST',
            body: new URLSearchParams({
                token: purge.dataset.token,
            }),
        });

        const lis = document.querySelectorAll('li');
        lis.forEach(li => {
            if (li.children[0].checked) {
                li.remove();
            }
        });
    });
}