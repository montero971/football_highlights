import React, { useState } from "react";
import { useNavigate } from "react-router-dom";

import { PrimeReactProvider } from "primereact/api";
import { FloatLabel } from "primereact/floatlabel";
import { Password } from "primereact/password";
import { Divider } from "primereact/divider";

import CustomFloatLabel from "../SignUp/CustomFloatLabel";

import "../SignUp/SignUp.css";
import "./SignIn.css";
import { Button } from "primereact/button";

function SignIn() {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [errorMessage, setErrorMessage] = useState("");

  const navigate = useNavigate();

  const passwordHeader = <h4>Pick a password</h4>;
  const passwordFooter = (
    <React.Fragment>
      <Divider />
      <p className="mt-2">Suggestions</p>
      <ul className="pl-2 ml-2 mt-0" style={{ lineHeight: "1.5" }}>
        <li>At least one lowercase</li>
        <li>At least one uppercase</li>
        <li>At least one numeric</li>
        <li>Minimum 8 characters</li>
      </ul>
    </React.Fragment>
  );

  const handleButtonClick = async () => {
    try {
      const response = await fetch("https://localhost:8000/user/login", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ email, password }),
      });

      if (response.ok) {
        navigate("/");
      } else {
        const responseData = await response.json();
        setErrorMessage(responseData.error);
      }
    } catch (error) {
      setErrorMessage("Error during request: " + error.message);
    }
  };

  return (
    <PrimeReactProvider>
      <div className="title">
        <h1>Sign In</h1>
      </div>
      <div className="loginContainer">
        <div className="loginForm">
          <div className="loginFloatLabel">
            <CustomFloatLabel
              id="email"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              label="Email"
              iconClassName="pi pi-envelope"
            />
          </div>
          <div className="loginFloatLabel">
            <FloatLabel>
              <Password
                inputId="password"
                value={password}
                toggleMask
                onChange={(e) => setPassword(e.target.value)}
                header={passwordHeader}
                footer={passwordFooter}
              />
              <label htmlFor="password">
                Password
                {<i className="pi pi-key"></i>}
              </label>
            </FloatLabel>
          </div>
          <div className="signUpBtn">
            <Button
              label="Sign In"
              onClick={() => {
                handleButtonClick();
              }}
            />
          </div>
          {errorMessage && (
            <p className="errorMessage">
              <i className="pi pi-exclamation-circle"></i>
              {errorMessage}
            </p>
          )}
        </div>
      </div>
    </PrimeReactProvider>
  );
}

export default SignIn;
