function onClickBtnLike(event){
    event.preventDefault();

    const url = this.href;
    const spanCount = this.querySelector('span.js-likes');
    const likeIcon = this.querySelector('div.likeIcon');

    axios.get(url).then(function(response){
        spanCount.textContent = response.data.likes;

        if(likeIcon.classList.contains('likeRed')) {
            likeIcon.classList.replace('likeRed', 'likeWhite');
        } else {
            likeIcon.classList.replace('likeWhite', 'likeRed');
        }
    }).catch(function(error){
        if(error.response.status === 403) {
            window.alert("Vous ne pouvez pas liker un article si vous n'êtes pas connecter");
        } else {
            window.alert("Une erreur s'est produite, réessayer plus tard");
        }
    });
}

document.querySelectorAll('a.js-like').forEach(function(link){
    link.addEventListener('click', onClickBtnLike);
}) 





