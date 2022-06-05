import CommentFom from '../../../forms/CommentFom'

export default function Comment ({ postId }) {
  return (
    <div className="post-comment-form">
      <CommentFom postId={postId}/>
    </div>
  )
}