/**
 * jquery.pngfix.js 用の実行コード
 *
 * site: Advanced Creators 模擬店2008『はまーの手作りですけど何か？』
 * 
 * img要素がPNGだった場合は透過処理を実行する記述
 * ref=http://www.cssmake.com/2008/06/ie6imgpng.html
 *
 * および、div#headerのbackground-imageに適用
 */

$(document).ready(function() {
$("img[@src$=png]").pngfix();
});
