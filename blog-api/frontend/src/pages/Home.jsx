import { useEffect, useState } from "react";
import api from "../api/axios";
import Navbar from "../components/Navbar";
import BlogCard from "../components/BlogCard";

const Home = () => {
  const [posts, setPosts] = useState([]);

  const load = () => {
    api.get("posts/get_posts.php").then(res => setPosts(res.data));
  };

  useEffect(load, []);

  return (
    <>
      <Navbar />
      <div className="container mt-4">
        <h4>Blog Posts</h4>

         <div className="grid md:grid-cols-3 gap-6">
          {posts.map(p => (
            <BlogCard key={p.id} post={p} refresh={load} />
          ))}
        </div>
      </div>
    </>
  );
}


export default Home;