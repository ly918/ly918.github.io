getUrlParameter = name => {
  name = name
    .replace(/[]/, "[")
    .replace(/[]/, "[")
    .replace(/[]/, "\\]");
  var regexS = "[\\?&]" + name + "=([^&#]*)";
  var regex = new RegExp(regexS);
  var results = regex.exec(window.parent.location.href);
  if (results == null) return "";
  else {
    return results[1];
  }
};
