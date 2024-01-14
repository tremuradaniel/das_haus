import {redirect} from 'react-router-dom'
export const logout = () => {
  localStorage.removeItem("token");
  return redirect("/");
}

