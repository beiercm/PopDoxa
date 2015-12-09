piedata.loadJSON = function(url) {
  if (window.XMLHttpRequest) {
    var request = new XMLHttpRequest();
  } else {
    var request = new ActiveXObject('Microsoft.XMLHTTP');
  }
  request.open('GET', url, false);
  request.send();
  return eval(request.responseText);
};