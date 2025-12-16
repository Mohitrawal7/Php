import { Link } from "react-router-dom";
import api from "../api/axios";

const BlogCard = ({ post, refresh }) => {

  const remove = async () => {
    if (!confirm("Delete this blog?")) return;
    try {
      const fd = new FormData();
      fd.append("id", post.id);
      await api.post("posts/delete_post.php", fd);
      refresh(); // reload posts after deletion
    } catch (err) {
      alert("Failed to delete post");
    }
  };

  return (
    <div className="bg-white rounded-lg shadow hover:shadow-lg transition">
      {post.image && (
        <img
          src={`http://localhost/blog-app/uploads/${post.image}`}
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
          onClick={remove}
          className="text-red-600 hover:underline"
        >
          Delete
        </button>
      </div>
    </div>
  );
}

export default BlogCard;