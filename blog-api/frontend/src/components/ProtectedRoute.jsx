import { Navigate } from "react-router-dom";
import { useEffect, useState } from "react";
import api from "../api/axios";

const ProtectedRoute = ({ children }) => {
  const [loading, setLoading] = useState(true);
  const [auth, setAuth] = useState(false);

  useEffect(() => {
    const checkSession = async () => {
      try {
        const res = await api.get("index.php"); // call your PHP session check
        setAuth(res.data.session_active);
      } catch (err) {
        setAuth(false);
      } finally {
        setLoading(false);
      }
    };

    checkSession();
  }, []);

  if (loading) return <p className="text-center mt-5">Checking session...</p>;

  return auth ? children : <Navigate to="/login" />;
};

export default ProtectedRoute;
