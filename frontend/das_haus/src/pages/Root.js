import { Outlet } from "react-router-dom";

import NavigationBar from '../components/Navbar.js'
const RootLayout = () => {
  
      return (
        <>
          <NavigationBar/>
          <main >
          <Outlet/>
          </main>
        </>
      );
    };
    
    export default RootLayout;