import React, { useState, useEffect } from "react";
import { PrimeReactProvider } from "primereact/api";
import "primereact/resources/primereact.css";
import "primereact/resources/themes/lara-light-indigo/theme.css";
import { FloatLabel } from "primereact/floatlabel";
import { Password } from "primereact/password";
import { Checkbox } from "primereact/checkbox";
import { Divider } from "primereact/divider";
import { Button } from "primereact/button";
import CustomFloatLabel from "./CustomFloatLabel";
import NotificationText from "./Notifications/NotificationText";
import { notifySignUpSuccess } from "./Notifications/NotificationService";
import { ToastContainer } from "react-toastify";
import "./SignUp.css";
import "react-toastify/dist/ReactToastify.css";

function SignUp() {
  const [firstName, setFirstName] = useState("");
  const [lastName, setLastName] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [team, setTeam] = useState("");
  const [checked, setChecked] = useState(false);
  const [submitExecuted, setSubmitExecuted] = useState(false);
  const [formErrors, setFormErrors] = useState({ firstName: "" });

  useEffect(() => {
    if (submitExecuted) {
      handleSubmit();
    }
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [submitExecuted]);

  const resetForm = () => {
    setFirstName("");
    setLastName("");
    setEmail("");
    setPassword("");
    setTeam("");
    setChecked(false);
    setFormErrors({ firstName: "" });
  };

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

  const handleSubmit = async () => {
    try {
      if (!firstName) {
        setFormErrors({ firstName: "First name is required" });
        return;
      }
      
      const response = await fetch("https://localhost:8000/user/signup", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          firstName,
          lastName,
          email,
          password,
          team,
          subscribed: checked ? 1 : 0,
        }),
      });
      if (response.ok) {
        notifySignUpSuccess();
        resetForm();
      } else {
        console.error("Error al registrar usuario", response.statusText);
      }
    } catch (error) {
      console.error("Error en la solicitud:", error.message);
    }
  };

  const handleButtonClick = () => {
    setSubmitExecuted(true);
  };

  return (
    <PrimeReactProvider>
      <ToastContainer />
      <div className="title">
        <h1>Sign Up</h1>
      </div>
      <div className="container">
        <div className="form">
          <CustomFloatLabel
            id="firstname"
            value={firstName}
            onChange={(e) => setFirstName(e.target.value)}
            label="Firstname"
            iconClassName="pi pi-user"
            error={formErrors.firstName}
          />
          <CustomFloatLabel
            id="lastname"
            value={lastName}
            onChange={(e) => setLastName(e.target.value)}
            label="Lastname"
            iconClassName="pi pi-user"
          />
          <CustomFloatLabel
            id="email"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
            label="Email"
            iconClassName="pi pi-envelope"
          />
          <div className="floatLabel">
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
          <CustomFloatLabel
            id="team"
            value={team}
            onChange={(e) => setTeam(e.target.value)}
            label="Your team"
            iconClassName="pi pi-flag"
          />
          <div className="notificationsContainer">
            <NotificationText />
            <div className="checkBox">
              <Checkbox
                onChange={(e) => setChecked(e.checked)}
                checked={checked}
              ></Checkbox>
            </div>
          </div>
          <div className="signUpBtn">
            <Button
              label="Sign Up"
              icon="pi pi-check"
              onClick={() => {
                handleButtonClick();
              }}
            />
          </div>
        </div>
      </div>
    </PrimeReactProvider>
  );
}

export default SignUp;
