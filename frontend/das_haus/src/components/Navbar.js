import Container from "react-bootstrap/Container";
import Nav from "react-bootstrap/Nav";
import Navbar from "react-bootstrap/Navbar";
import NavDropdown from "react-bootstrap/NavDropdown";
import Offcanvas from "react-bootstrap/Offcanvas";
import { useNavigate } from "react-router-dom";
import { NavLink } from "react-router-dom";
import { logout } from "../logout";
function NavigationBar() {
  let isLoggedIn = localStorage.getItem("token");
  let navigate = useNavigate();

  const logoutHandler = () => {
    logout();
    navigate("/");
  };
  return (
    <>
      {[false].map((expand) => (
        <Navbar key={expand} expand={expand} className="bg-body-tertiary mb-3">
          <Container fluid>
            <Navbar.Toggle aria-controls={`offcanvasNavbar-expand-${expand}`} />
            <Navbar.Offcanvas
              id={`offcanvasNavbar-expand-${expand}`}
              aria-labelledby={`offcanvasNavbarLabel-expand-${expand}`}
              placement="start"
            >
              <Offcanvas.Header closeButton>
                <Offcanvas.Title id={`offcanvasNavbarLabel-expand-${expand}`}>
                  Menu
                </Offcanvas.Title>
              </Offcanvas.Header>
              <Offcanvas.Body>
                <Nav className="justify-content-end flex-grow-1 pe-3">
                  <NavLink to="/">HomePage</NavLink>
                  <NavLink to="/landing">Landing Page</NavLink>
                  <NavDropdown
                    title="Dropdown"
                    id={`offcanvasNavbarDropdown-expand-${expand}`}
                  >
                    <NavDropdown.Item href="#action3">Action</NavDropdown.Item>
                    <NavDropdown.Item href="#action4">
                      Another action
                    </NavDropdown.Item>
                    <NavDropdown.Divider />
                    <NavDropdown.Item href="#action5">
                      Something else here
                    </NavDropdown.Item>
                  </NavDropdown>
                </Nav>
              </Offcanvas.Body>
            </Navbar.Offcanvas>

            <NavLink to="/">DAS HAUS</NavLink>
            {!isLoggedIn && (
              <NavLink to="/auth?mode=login" className="nav-link">
                Authentication
              </NavLink>
            )}
            {isLoggedIn && (
              <Nav.Link onClick={logoutHandler} className="nav-link">
                Logout
              </Nav.Link>
            )}
          </Container>
        </Navbar>
      ))}
    </>
  );
}

export default NavigationBar;
