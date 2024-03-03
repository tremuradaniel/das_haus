import "bootstrap/dist/css/bootstrap.css";
import "./App.css";
import { RouterProvider, createBrowserRouter } from "react-router-dom";
import HomePage from "./pages/Home";
import RootLayout from "./pages/Root";
import AuthenticationPage from "./pages/Auth";
import LandingPage from "./pages/Landing";
import { action as authAction } from "./components/AuthForm";
import { routeProtectionLoader } from "./util/routeProtection";
function App() {
  const router = createBrowserRouter([
    {
      path: "/",
      element: <RootLayout />,
      children: [
        { path: "/", index: true, element: <HomePage /> },
        {
          path: "auth/",
          element: <AuthenticationPage />,
          action: authAction,
          name: "auth",
        },
        {
          path: "landing",
          element: <LandingPage />,
          loader: routeProtectionLoader,
        },
      ],
    },
  ]);

  return <RouterProvider router={router} />;
}

export default App;
