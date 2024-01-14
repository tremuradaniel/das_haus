import "../styles/AuthForm.css";
import loginPhoto from "../styles/login-photo.jpg";
import { Form, Link, useSearchParams, json, redirect } from "react-router-dom";
import axios from "axios";

function AuthForm() {
  const [searchParams] = useSearchParams();
  const isLogin = searchParams.get("mode") === "login";

  return (
    <section className="ftco-section">
      <div className="container">
        <div className="row justify-content-center"></div>
        <div className="row justify-content-center">
          <div className="col-md-12 col-lg-10">
            <div className="wrap d-md-flex">
              <div
                className="img"
                style={{ backgroundImage: `url(${loginPhoto})` }}
              ></div>
              <div className="login-wrap p-4 p-md-5">
                <div className="d-flex">
                  <div className="w-100">
                    <h3 className="mb-4">
                      {isLogin ? "Sign In" : "Create a new user"}
                    </h3>
                  </div>
                </div>
                <Form method="POST" className="signin-form">
                  <div className="form-group mb-3">
                    <label className="label" htmlFor="name">
                      Username
                    </label>
                    <input
                      className="form-control"
                      placeholder="Username"
                      id="email"
                      type="email"
                      name="email"
                      required
                    />
                  </div>
                  <div className="form-group mb-3">
                    <label className="label" htmlFor="password">
                      Password
                    </label>
                    <input
                      type="password"
                      className="form-control"
                      placeholder="Password"
                      id="password"
                      name="password"
                      required
                    />
                  </div>
                  <div className="form-group">
                    <button
                      type="submit"
                      className="form-control btn btn-primary rounded submit px-3"
                    >
                      {isLogin ? "Sign In" : "Create a new user"}
                    </button>
                  </div>
                </Form>
                <p className="text-center">
                  {isLogin ? "Not a member?" : "Already a member?"}{" "}
                  <Link to={`?mode=${isLogin ? "signup" : "login"}`}>
                    {" "}
                    {isLogin ? "Create new user" : "Login"}
                  </Link>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}

export default AuthForm;

export async function action({ request, params }) {
  const method = request.method;
  const searchParams = new URL(request.url).searchParams;
  const mode = searchParams.get("mode");
  const data = await request.formData();
  let userData = {
    email: data.get("email"),
    password: data.get("password"),
  };

  if (mode !== "login" && mode !== "signup") {
    throw json({ message: "Unsupported mode." }, { status: 422 });
  }

  if (method === "POST") {
    if (mode === "signup") {
      let data = JSON.stringify({
        email: userData.email,
        password: userData.password,
      });

      let config = {
        method: "post",
        maxBodyLength: Infinity,
        url: "http://localhost:8000/api/registration",
        headers: {
          "Content-Type": "application/json",
        },
        data: data,
      };

      axios
        .request(config)
        .then((response) => {
          console.log(JSON.stringify(response.data));
          return redirect("/");
        })
        .catch((error) => {
          console.log(error);
        });
      }
      if (mode === "login") {
        let data = JSON.stringify({
          username: userData.email,
          password: userData.password,
        });

        let config = {
          method: "post",
          maxBodyLength: Infinity,
          url: "http://localhost:8000/api/login_check",
          headers: {
            "Content-Type": "application/json",
          },
          data: data,
        };

        axios
          .request(config)
          .then((response) => {
            console.log(JSON.stringify(response.data));
            const parsedResponse = JSON.parse(JSON.stringify(response.data));
            const token = parsedResponse.token;
            localStorage.setItem('token', token)
            return redirect("/");
          })
          .catch((error) => {
            console.log(error);
          });
      }
    

      return redirect("/");
  }
}
