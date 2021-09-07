//subMenu 
const profileIcon = document.getElementById('panel');
const triangle = document.querySelector('#panel');
const subMenu = document.getElementById('panelMenu');

var disr = window.getComputedStyle(document.querySelector('#panel'), ':after');

console.log(disr.getPropertyValue('display'));

profileIcon.addEventListener('click', function () {
    subMenu.classList.toggle("menuToggle");
})

document.addEventListener('click', function (event) {
    var isClickInsideElement = profileIcon.contains(event.target);
    if (!isClickInsideElement) {
        subMenu.classList.add("menuToggle");
        triangle.style.after = 'red';
    }
});

//form
// const nextBtn = document.getElementById('next');
// const prevBtn = document.getElementById('prev');

// const inputBox1 = document.getElementById('input1');
// const inputBox2 = document.getElementById('input2');


// nextBtn.addEventListener('click', function () {
//     inputBox1.style.display = "none";
//     inputBox2.style.display = "initial";
// })

// prevBtn.addEventListener('click', function () {
//     inputBox1.style.display = "initial";
//     inputBox2.style.display = "none";
// })

// //modalForm
// const modalTrigger = document.getElementById('toggleModal');
// const modalWrapper = document.getElementById('modalWrapper');
// const closeBtn = document.getElementById('close');

// modalTrigger.addEventListener('click', function () {
//     modalWrapper.style.height = "100%";
// })

// closeBtn.addEventListener('click', function () {
//     modalWrapper.style.height = "0%";
// })

//------submit Thumbnail
const inputFile = document.getElementById('file');
inputFile.addEventListener('change',function(){
    this.form.submit();
})


