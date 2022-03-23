const CategoryCard = (props) => {
    const handleClick = () => {
        props.selectCategory(props.category);
    };
    const isSelected = props.selectedCategory && props.selectedCategory.id == props.category.id;
    return(
        <li className="vertical-list__item">
            <div className="vertical-list__item__card" onClick={handleClick} data-selected={isSelected} >{props.category.name}</div>
        </li>
    )
}

export default CategoryCard;
