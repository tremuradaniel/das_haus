import { redirect } from "react-router-dom";

export function routeProtectionLoader() {
  let isAuthenticated = localStorage.getItem("token");
  if (!isAuthenticated) {
    return redirect("/auth?mode=login");
  } else {
    return null;
  }
}
