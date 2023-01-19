    auto t = std::time(nullptr);
    auto tm = *std::localtime(&t);
    std::cout << std::put_time(&tm, "%Y-%m-%d_%H%M%S") << std::endl;