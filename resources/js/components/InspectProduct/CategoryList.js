import CategoryCard from "./CategoryCard";

const CategoryList = (props) => {
    const categories = props.categories;
    const checklistCategories = categories? categories.filter( (category) => category.form == 'CHECKLIST')
    .map((category) => (<CategoryCard key={category.id} category={category} selectCategory={props.selectCategory} selectedCategory={props.selectedCategory}/>)):null;
    const mappingCategories = categories? categories.filter( (category) => category.form == 'MAPPING')
    .map((category) => (<CategoryCard key={category.id} category={category} selectCategory={props.selectCategory} selectedCategory={props.selectedCategory}/>)):null;
    return(
        <ul className="vertical-list">
            <li className="vertical-list__item">CheckList
                <ul className="vertical-list">
                    {checklistCategories}
                </ul>
            </li>
            <li className="vertical-list__item">Mapping
                <ul className="vertical-list">
                    {mappingCategories}
                </ul>
            </li>
        </ul>
    )
}

export default CategoryList;
