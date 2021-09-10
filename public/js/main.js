//-----------subMenu 
const profileIcon = document.getElementById('panel');
const subMenu = document.getElementById('panelMenu');

if(profileIcon) {
    profileIcon.addEventListener('click', function () {
        subMenu.classList.toggle("menuToggle");
        profileIcon.classList.toggle("speechBubble");
    })
    
    document.addEventListener('click', function (event) {
        var isClickInsideElement = profileIcon.contains(event.target);
        if (!isClickInsideElement) {
            subMenu.classList.add("menuToggle");
            profileIcon.classList.add("speechBubble");
        }
    });
}


//------------- form
const nextBtn = document.getElementById('next');
const prevBtn = document.getElementById('prev');

const inputBox1 = document.getElementById('input1');
const inputBox2 = document.getElementById('input2');

if(nextBtn) {
    nextBtn.addEventListener('click', function () {
        inputBox1.style.display = "none";
        inputBox2.style.display = "initial";
    })
}

if(prevBtn) {
    prevBtn.addEventListener('click', function () {
        inputBox1.style.display = "initial";
        inputBox2.style.display = "none";
    })
}

// //---------------modalForm
const modalTrigger = document.getElementById('toggleModal');
const modalWrapper = document.getElementById('modalWrapper');
const closeBtn = document.getElementById('close');

if(modalTrigger) {
    modalTrigger.addEventListener('click', function () {
        modalWrapper.style.height = "100%";
    })
}

if(closeBtn){
    closeBtn.addEventListener('click', function () {
        modalWrapper.style.height = "0%";
    })
}

//------submit Thumbnail
const inputFile = document.getElementById('thumbnail_thumbnail');
const inputFile2 = document.getElementById('modalFile');
if (inputFile) {
    inputFile.addEventListener('change', function () {
        this.form.submit();
    })
}
if (inputFile2) {
    inputFile2.addEventListener('change', function () {
        this.form.submit();
    })
}

//-----Open modal Thumbnail
const userThumbnail = document.getElementById('userThumbnail');
const thumbnailModal = document.getElementById('thumbnailModal');
const cancelBtn = document.getElementById('cancel');
const settingModal = document.getElementById('settingModal');
const gear = document.getElementById('setting2');


if(userThumbnail) {
    userThumbnail.addEventListener('click', function () {
        thumbnailModal.style.display = 'initial';
    }) 
}

if(gear) {
    gear.addEventListener('click', function () {
        settingModal.style.display = 'initial';
    }) 
}

if(cancelBtn) {
    cancelBtn.addEventListener('click', closeModal);
    settingModal.addEventListener('click', closeModal);
}

if(thumbnailModal) {
    thumbnailModal.addEventListener('click', closeModal);
}

function closeModal() {
    if(thumbnailModal) {
        thumbnailModal.style.display = 'none';
    }
    settingModal.style.display = 'none';
}


