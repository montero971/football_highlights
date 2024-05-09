import PropTypes from "prop-types";
import { FloatLabel } from "primereact/floatlabel";
import { InputText } from "primereact/inputtext";

function CustomFloatLabel({ id, value, onChange, label, iconClassName }) {
  return (
    <div className="floatLabel">
      <FloatLabel>
        <InputText id={id} value={value} onChange={onChange} />
        <label htmlFor={id}>
          {label}
          {iconClassName && <i className={iconClassName}></i>}
        </label>
      </FloatLabel>
    </div>
  );
}

CustomFloatLabel.propTypes = {
  id: PropTypes.string.isRequired,
  value: PropTypes.string.isRequired,
  onChange: PropTypes.func.isRequired,
  label: PropTypes.string.isRequired,
  iconClassName: PropTypes.string.isRequired,
};

export default CustomFloatLabel;
