import { Link } from "react-router-dom";
import api from "../api/axios";

const BlogCard = ({ post, refresh }) => {
console.log(post);

 const deletePost = async (id) => {
  try {
    console.log("Deleting post", id);

    const res = await api.delete("posts/delete_post.php", {
      data: { id }, // must be inside `data`    
    });

    console.log(res.data); // debug response

    if (res.data.success) {
      alert("Post deleted successfully");
      refresh(); // refresh posts list in parent
    } else {
      alert(res.data.error);
    }
  } catch (err) {
    console.error(err.response?.data || err);
    alert(err.response?.data?.error || "Something went wrong");
  }
};




  return (
    <div className="bg-white rounded-lg shadow hover:shadow-lg transition">
      {post.image && (
        <img
          src={`http://localhost/PHP/blog-api/backend/uploads/${post.image}`}
          className="w-full h-48 object-cover rounded-t-lg"
        />
      )}
      <div className="p-4">
        <h3 className="font-semibold text-lg">{post.title}</h3>
        <p className="text-gray-600 text-sm mt-2">
          {post.content.slice(0, 90)}...
        </p>
      </div>
      <div className="px-4 pb-4 flex justify-between">
        <Link
          to={`/edit/${post.id}`}
          className="text-blue-600 hover:underline"
        >
          Edit
        </Link>
        <button
          onClick={() => deletePost(post.id)}
          className="text-red-600 hover:underline"
        >
          Delete
        </button>
      </div>
    </div>
  );
}

export default BlogCard;