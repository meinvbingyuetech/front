/*
 搜索页搜索
 */
function search_search() {
    var query_word = $.trim(document.getElementById('wd-search').value);
    if(query_word=='搜索'){query_word=0;}
    if (query_word) {
        /*if (query_word.indexOf('+')>=0) {
         query_word = query_word.replace('+', '');
         }*/
        query_word = query_word.replace(/\s/g,"+");
        location.href='/search/'+encodeURIComponent(query_word)+'-all.html';
    } else {
        error_show(lang_searchslgjc);
        document.getElementById('wd-search').focus();
    }
    return false;
}