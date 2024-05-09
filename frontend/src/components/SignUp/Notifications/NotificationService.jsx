import { toast, Bounce } from "react-toastify";

export const notifySignUpSuccess = () => {
  toast(
    "🚀 Sign Up was successful! We have sent you an email, please check it out",
    {
      position: "top-center",
      autoClose: 2000,
      hideProgressBar: false,
      closeOnClick: true,
      pauseOnHover: false,
      draggable: true,
      progress: undefined,
      theme: "light",
      transition: Bounce,
    }
  );
};
