window.sessionStorage.setItem("Secure.IsUserLoggedIn?", "No");
window.sessionStorage.setItem("Secure.AuthenticationToken", Array.from(crypto.getRandomValues(new Uint8Array(16)), b => b.toString(16).padStart(2, "0")).join(""));
window.localStorage.setItem("Secure.CurrentStateofHTML5Storage","Completely Insecure");
