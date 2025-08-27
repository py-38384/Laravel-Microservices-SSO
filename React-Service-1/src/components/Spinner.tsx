
export default function Spinner({ show }: {show: boolean}) {
  if (!show) return null; // hide if show=false

  return (
    <div id="spinner">
        <div></div>
    </div>
  );
}
